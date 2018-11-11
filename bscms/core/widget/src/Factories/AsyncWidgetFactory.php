<?php

namespace Bytesoft\Widget\Factories;

use Bytesoft\Widget\Misc\InvalidWidgetClassException;
use Exception;

class AsyncWidgetFactory extends AbstractWidgetFactory
{
    /**
     * Run widget without magic method.
     *
     * @return mixed
     * @author Bytesoft
     */
    public function run()
    {
        try {
            $this->instantiateWidget(func_get_args());
        } catch (InvalidWidgetClassException $exception) {
            return $exception->getMessage();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }

        $placeholder = call_user_func([$this->widget, 'placeholder']);
        $loader = $this->javascriptFactory->getLoader();
        $content = $this->wrapContentInContainer($placeholder . $loader);

        return $this->convertToViewExpression($content);
    }
}
