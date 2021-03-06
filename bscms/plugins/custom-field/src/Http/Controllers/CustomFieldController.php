<?php

namespace Bytesoft\CustomField\Http\Controllers;

use Assets;
use Bytesoft\Base\Forms\FormBuilder;
use Bytesoft\Base\Http\Controllers\BaseController;
use Bytesoft\Base\Http\Responses\BaseHttpResponse;
use Bytesoft\CustomField\Actions\CreateCustomFieldAction;
use Bytesoft\CustomField\Actions\DeleteCustomFieldAction;
use Bytesoft\CustomField\Actions\ExportCustomFieldsAction;
use Bytesoft\CustomField\Actions\ImportCustomFieldsAction;
use Bytesoft\CustomField\Actions\UpdateCustomFieldAction;
use Bytesoft\CustomField\Forms\CustomFieldForm;
use Bytesoft\CustomField\Tables\CustomFieldTable;
use Bytesoft\CustomField\Http\Requests\CreateFieldGroupRequest;
use Bytesoft\CustomField\Http\Requests\UpdateFieldGroupRequest;
use Bytesoft\CustomField\Repositories\Interfaces\FieldItemInterface;
use Bytesoft\CustomField\Repositories\Interfaces\FieldGroupInterface;
use CustomField;
use Exception;
use Illuminate\Http\Request;

class CustomFieldController extends BaseController
{

    /**
     * @var FieldGroupInterface
     */
    protected $fieldGroupRepository;

    /**
     * @var FieldItemInterface
     */
    protected $fieldItemRepository;

    /**
     * @param FieldGroupInterface $fieldGroupRepository
     * @param FieldItemInterface $fieldItemRepository
     * @author Bytesoft
     */
    public function __construct(FieldGroupInterface $fieldGroupRepository, FieldItemInterface $fieldItemRepository)
    {
        $this->fieldGroupRepository = $fieldGroupRepository;
        $this->fieldItemRepository = $fieldItemRepository;
    }

    /**
     * @param CustomFieldTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Bytesoft
     * @throws \Throwable
     */
    public function getList(CustomFieldTable $dataTable)
    {
        page_title()->setTitle(trans('plugins.custom-field::base.page_title'));

        Assets::addJavascriptDirectly('vendor/core/plugins/custom-field/js/import-field-group.js')
            ->addJavascript(['blockui']);

        return $dataTable->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     * @author Bytesoft
     * @throws \Throwable
     */
    public function getCreate(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins.custom-field::base.form.create_field_group'));

        Assets::addStylesheetsDirectly([
                'vendor/core/plugins/custom-field/css/custom-field.css',
                'vendor/core/plugins/custom-field/css/edit-field-group.css',
            ])
            ->addJavascriptDirectly('vendor/core/plugins/custom-field/js/edit-field-group.js')
            ->addJavascript(['jquery-ui']);

        return $formBuilder->create(CustomFieldForm::class)->renderForm();
    }

    /**
     * @param CreateFieldGroupRequest $request
     * @param CreateCustomFieldAction $action
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @author Bytesoft
     */
    public function postCreate(
        CreateFieldGroupRequest $request,
        CreateCustomFieldAction $action,
        BaseHttpResponse $response
    )
    {
        $result = $action->run($request->input());

        $is_error = false;
        $message = trans('core.base::notices.create_success_message');
        if ($result['error']) {
            $is_error = true;
            $message = $result['message'];
        }

        return $response
            ->setError($is_error)
            ->setPreviousUrl(route('custom-fields.list'))
            ->setNextUrl(route('custom-fields.edit', $result['data']['id']))
            ->setMessage($message);
    }

    /**
     * @param $id
     * @param FormBuilder $formBuilder
     * @return string
     * @author Bytesoft, Tedozi Manson
     * @throws \Throwable
     */
    public function getEdit($id, FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins.custom-field::base.form.edit_field_group') . ' #' . $id);

        Assets::addStylesheetsDirectly([
                'vendor/core/plugins/custom-field/css/custom-field.css',
                'vendor/core/plugins/custom-field/css/edit-field-group.css',
            ])
            ->addJavascriptDirectly('vendor/core/plugins/custom-field/js/edit-field-group.js')
            ->addJavascript(['jquery-ui']);

        $object = $this->fieldGroupRepository->findOrFail($id);

        $object->rules_template = CustomField::renderRules();

        return $formBuilder->create(CustomFieldForm::class)->setModel($object)->renderForm();
    }

    /**
     * @param $id
     * @param UpdateFieldGroupRequest $request
     * @param UpdateCustomFieldAction $action
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @author Bytesoft, Tedozi Manson
     */
    public function postEdit(
        $id,
        UpdateFieldGroupRequest $request,
        UpdateCustomFieldAction $action,
        BaseHttpResponse $response
    )
    {
        $result = $action->run($id, $request->input());

        $is_error = false;
        $message = trans('core.base::notices.update_success_message');
        if ($result['error']) {
            $is_error = true;
            $message = $result['message'];
        }

        return $response
            ->setError($is_error)
            ->setPreviousUrl(route('custom-fields.list'))
            ->setMessage($message);
    }

    /**
     * @param $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param DeleteCustomFieldAction $action
     * @return BaseHttpResponse
     * @author Bytesoft
     */
    public function getDelete($id, BaseHttpResponse $response, DeleteCustomFieldAction $action)
    {
        try {
            $action->run($id);
            return $response->setMessage(trans('plugins.custom-field::field-groups.deleted'));
        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setMessage(trans('plugins.custom-field::field-groups.cannot_delete'));
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param DeleteCustomFieldAction $action
     * @return BaseHttpResponse
     * @author Bytesoft
     */
    public function postDeleteMany(Request $request, BaseHttpResponse $response, DeleteCustomFieldAction $action)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('plugins.custom-field::field-groups.notices.no_select'));
        }

        foreach ($ids as $id) {
            $action->run($id);
        }

        return $response->setMessage(trans('plugins.custom-field::field-groups.field_group_deleted'));
    }

    /**
     * @param ExportCustomFieldsAction $action
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getExport(ExportCustomFieldsAction $action, $id = null)
    {
        $ids = [];

        if (!$id) {
            foreach ($this->fieldGroupRepository->all() as $item) {
                $ids[] = $item->id;
            }
        } else {
            $ids[] = $id;
        }

        $json = $action->run($ids)['data'];

        return response()->json($json, 200, [
            'Content-type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="export-field-group.json"',
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param ImportCustomFieldsAction $action
     * @param Request $request
     * @return array
     * @throws Exception
     * @throws Exception
     */
    public function postImport(ImportCustomFieldsAction $action, Request $request)
    {
        $json = $request->input('json_data');

        return $action->run($json);
    }
}
