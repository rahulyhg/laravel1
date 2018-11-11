<?php

namespace Bytesoft\Blog\Http\Controllers;

use Bytesoft\Base\Events\BeforeEditContentEvent;
use Bytesoft\Base\Forms\FormBuilder;
use Bytesoft\Base\Http\Controllers\BaseController;
use Bytesoft\Base\Http\Responses\BaseHttpResponse;
use Bytesoft\Blog\Forms\PostForm;
use Bytesoft\Blog\Http\Requests\PostRequest;
use Assets;
use Bytesoft\Blog\Models\Post;
use Bytesoft\Blog\Repositories\Interfaces\CategoryInterface;
use Bytesoft\Blog\Repositories\Interfaces\PostInterface;
use Bytesoft\Blog\Tables\PostTable;
use Bytesoft\Blog\Repositories\Interfaces\TagInterface;
use Bytesoft\Blog\Services\StoreCategoryService;
use Bytesoft\Blog\Services\StoreTagService;
use Exception;
use Illuminate\Http\Request;
use Auth;
use Bytesoft\Base\Events\CreatedContentEvent;
use Bytesoft\Base\Events\DeletedContentEvent;
use Bytesoft\Base\Events\UpdatedContentEvent;

class PostController extends BaseController
{

    /**
     * @var PostInterface
     */
    protected $postRepository;

    /**
     * @var TagInterface
     */
    protected $tagRepository;

    /**
     * @var CategoryInterface
     */
    protected $categoryRepository;

    /**
     * @param PostInterface $postRepository
     * @param TagInterface $tagRepository
     * @param CategoryInterface $categoryRepository
     * @author Bytesoft
     */
    public function __construct(
        PostInterface $postRepository,
        TagInterface $tagRepository,
        CategoryInterface $categoryRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param PostTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Bytesoft
     * @throws \Throwable
     */
    public function getList(PostTable $dataTable)
    {
        page_title()->setTitle(trans('plugins.blog::posts.menu_name'));

        return $dataTable->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     * @author Bytesoft
     */
    public function getCreate(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins.blog::posts.create'));

        Assets::addJavascript(['bootstrap-tagsinput', 'typeahead'])
            ->addStylesheets(['bootstrap-tagsinput'])
            ->addAppModule(['tags']);

        return $formBuilder->create(PostForm::class)->renderForm();
    }

    /**
     * @param PostRequest $request
     * @param StoreTagService $tagService
     * @param StoreCategoryService $categoryService
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @author Bytesoft
     */
    public function postCreate(
        PostRequest $request,
        StoreTagService $tagService,
        StoreCategoryService $categoryService,
        BaseHttpResponse $response
    ) {
        /**
         * @var Post $post
         */
        $post = $this->postRepository->createOrUpdate(array_merge($request->input(), [
            'user_id' => Auth::user()->getKey(),
            'featured' => $request->input('featured', false),
        ]));

        event(new CreatedContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));

        $tagService->execute($request, $post);

        $categoryService->execute($request, $post);

        return $response
            ->setPreviousUrl(route('posts.list'))
            ->setNextUrl(route('posts.edit', $post->id))
            ->setMessage(trans('core.base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param FormBuilder $formBuilder
     * @param Request $request
     * @return string
     * @author Bytesoft
     */
    public function getEdit($id, FormBuilder $formBuilder, Request $request)
    {
        $post = $this->postRepository->findOrFail($id);

        event(new BeforeEditContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));

        page_title()->setTitle(trans('plugins.blog::posts.edit') . ' #' . $id);

        Assets::addJavascript(['bootstrap-tagsinput', 'typeahead'])
            ->addStylesheets(['bootstrap-tagsinput'])
            ->addAppModule(['tags']);

        return $formBuilder->create(PostForm::class)->setModel($post)->renderForm();
    }

    /**
     * @param int $id
     * @param PostRequest $request
     * @param StoreTagService $tagService
     * @param StoreCategoryService $categoryService
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @author Bytesoft
     */
    public function postEdit(
        $id,
        PostRequest $request,
        StoreTagService $tagService,
        StoreCategoryService $categoryService,
        BaseHttpResponse $response
    ) {
        $post = $this->postRepository->findOrFail($id);

        $post->fill($request->input());
        $post->featured = $request->input('featured', false);

        $this->postRepository->createOrUpdate($post);

        event(new UpdatedContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));

        $tagService->execute($request, $post);

        $categoryService->execute($request, $post);

        return $response
            ->setPreviousUrl(route('posts.list'))
            ->setMessage(trans('core.base::notices.update_success_message'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return BaseHttpResponse
     * @author Bytesoft
     */
    public function getDelete(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $post = $this->postRepository->findOrFail($id);
            $this->postRepository->delete($post);

            event(new DeletedContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));

            return $response
                ->setMessage(trans('core.base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage(trans('core.base::notices.cannot_delete'));
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @author Bytesoft
     */
    public function postDeleteMany(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core.base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $post = $this->postRepository->findOrFail($id);
            $this->postRepository->delete($post);
            event(new DeletedContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));
        }

        return $response
            ->setMessage(trans('core.base::notices.delete_success_message'));
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws \Throwable
     * @author Bytesoft
     */
    public function getWidgetRecentPosts(Request $request, BaseHttpResponse $response)
    {
        $limit = $request->input('paginate', 10);
        $posts = $this->postRepository->getModel()->orderBy('created_at', 'desc')->paginate($limit);
        return $response
            ->setData(view('plugins.blog::posts.widgets.posts', compact('posts', 'limit'))->render());
    }
}