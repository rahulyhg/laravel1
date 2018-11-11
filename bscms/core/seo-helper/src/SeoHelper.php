<?php

namespace Bytesoft\SeoHelper;

use Bytesoft\SeoHelper\Contracts\SeoHelperContract;
use Bytesoft\SeoHelper\Contracts\SeoMetaContract;
use Bytesoft\SeoHelper\Contracts\SeoOpenGraphContract;
use Bytesoft\SeoHelper\Contracts\SeoTwitterContract;
use Exception;

class SeoHelper implements SeoHelperContract
{
    /**
     * The SeoMeta instance.
     *
     * @var \Bytesoft\SeoHelper\Contracts\SeoMetaContract
     */
    private $seoMeta;

    /**
     * The SeoOpenGraph instance.
     *
     * @var \Bytesoft\SeoHelper\Contracts\SeoOpenGraphContract
     */
    private $seoOpenGraph;

    /**
     * The SeoTwitter instance.
     *
     * @var \Bytesoft\SeoHelper\Contracts\SeoTwitterContract
     */
    private $seoTwitter;

    /**
     * Make SeoHelper instance.
     *
     * @param  \Bytesoft\SeoHelper\Contracts\SeoMetaContract $seoMeta
     * @param  \Bytesoft\SeoHelper\Contracts\SeoOpenGraphContract $seoOpenGraph
     * @param  \Bytesoft\SeoHelper\Contracts\SeoTwitterContract $seoTwitter
     * @author ARCANEDEV
     */
    public function __construct(
        SeoMetaContract $seoMeta,
        SeoOpenGraphContract $seoOpenGraph,
        SeoTwitterContract $seoTwitter
    )
    {
        $this->setSeoMeta($seoMeta);
        $this->setSeoOpenGraph($seoOpenGraph);
        $this->setSeoTwitter($seoTwitter);
    }

    /**
     * Get SeoMeta instance.
     *
     * @return \Bytesoft\SeoHelper\Contracts\SeoMetaContract
     * @author ARCANEDEV
     */
    public function meta()
    {
        return $this->seoMeta;
    }

    /**
     * Set SeoMeta instance.
     *
     * @param  \Bytesoft\SeoHelper\Contracts\SeoMetaContract $seoMeta
     *
     * @return \Bytesoft\SeoHelper\SeoHelper
     * @author ARCANEDEV
     */
    public function setSeoMeta(SeoMetaContract $seoMeta)
    {
        $this->seoMeta = $seoMeta;

        return $this;
    }

    /**
     * Get SeoOpenGraph instance.
     *
     * @return \Bytesoft\SeoHelper\Contracts\SeoOpenGraphContract
     * @author ARCANEDEV
     */
    public function openGraph()
    {
        return $this->seoOpenGraph;
    }

    /**
     * Get SeoOpenGraph instance.
     *
     * @param  \Bytesoft\SeoHelper\Contracts\SeoOpenGraphContract $seoOpenGraph
     *
     * @return \Bytesoft\SeoHelper\SeoHelper
     * @author ARCANEDEV
     */
    public function setSeoOpenGraph(SeoOpenGraphContract $seoOpenGraph)
    {
        $this->seoOpenGraph = $seoOpenGraph;

        return $this;
    }

    /**
     * Get SeoTwitter instance.
     *
     * @return \Bytesoft\SeoHelper\Contracts\SeoTwitterContract
     * @author ARCANEDEV
     */
    public function twitter()
    {
        return $this->seoTwitter;
    }

    /**
     * Set SeoTwitter instance.
     *
     * @param  \Bytesoft\SeoHelper\Contracts\SeoTwitterContract $seoTwitter
     *
     * @return \Bytesoft\SeoHelper\SeoHelper
     * @author ARCANEDEV
     */
    public function setSeoTwitter(SeoTwitterContract $seoTwitter)
    {
        $this->seoTwitter = $seoTwitter;

        return $this;
    }

    /**
     * Set title.
     *
     * @param  string $title
     * @param  string|null $siteName
     * @param  string|null $separator
     *
     * @return \Bytesoft\SeoHelper\SeoHelper
     * @author ARCANEDEV
     */
    public function setTitle($title, $siteName = null, $separator = null)
    {
        $this->meta()->setTitle($title, $siteName, $separator);
        $this->openGraph()->setTitle($title);
        $this->openGraph()->setSiteName($siteName);
        $this->twitter()->setTitle($title);

        return $this;
    }

    /**
     * Set description.
     *
     * @param  string $description
     *
     * @return \Bytesoft\SeoHelper\Contracts\SeoHelperContract
     * @author ARCANEDEV
     */
    public function setDescription($description)
    {
        $this->meta()->setDescription($description);
        $this->openGraph()->setDescription($description);
        $this->twitter()->setDescription($description);

        return $this;
    }

    /**
     * Set keywords.
     *
     * @param  array|string $keywords
     *
     * @return \Bytesoft\SeoHelper\SeoHelper
     * @author ARCANEDEV
     */
    public function setKeywords($keywords)
    {
        $this->meta()->setKeywords($keywords);

        return $this;
    }

    /**
     * Render all seo tags.
     *
     * @return string
     * @author ARCANEDEV
     */
    public function render()
    {
        return implode(PHP_EOL, array_filter([
            $this->meta()->render(),
            $this->openGraph()->render(),
            $this->twitter()->render(),
        ]));
    }

    /**
     * Render the tag.
     *
     * @return string
     * @author ARCANEDEV
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @param $screen
     * @param \Illuminate\Http\Request $request
     * @param $object
     * @return bool
     * @author Bytesoft
     */
    public function saveMetaData($screen, $request, $object)
    {
        if (in_array($screen, config('core.seo-helper.general.supported'))) {
            try {
                if (empty($request->input('seo_meta'))) {
                    delete_meta_data($object->id, 'seo_meta', $screen);
                    return false;
                }
                save_meta_data($object->id, 'seo_meta', $request->input('seo_meta'), $screen);
                return true;
            } catch (Exception $ex) {
                return false;
            }
        }
        return false;
    }

    /**
     * @param $screen
     * @param $object
     * @return bool
     * @author Bytesoft
     */
    public function deleteMetaData($screen, $object)
    {
        try {
            if (in_array($screen, config('core.seo-helper.general.supported'))) {
                delete_meta_data($object->id, 'seo_meta', $screen);
            }
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * @param string | array $screen
     * @return SeoHelper
     * @author Bytesoft
     */
    public function registerModule($screen)
    {
        if (!is_array($screen)) {
            $screen = [$screen];
        }
        config(['core.seo-helper.general.supported' => array_merge(config('core.seo-helper.general.supported'), $screen)]);
        return $this;
    }
}
