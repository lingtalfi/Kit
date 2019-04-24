<?php


namespace Ling\Kit\WidgetHandler;


use Ling\HtmlPageTools\Copilot\HtmlPageCopilot;

/**
 * The WidgetHandlerInterface interface.
 */
interface WidgetHandlerInterface
{


    /**
     * Returns the html code of the widget, according to the widget configuration.
     * If the widget uses some assets, or use some js code block, it also registers them to the given copilot.
     *
     * For more info about the copilot, see the @page(HtmlPageCopilot documentation).
     *
     * If something goes wrong, the widget should throw an exception.
     *
     * @param array $widgetConf
     * @param HtmlPageCopilot $copilot
     * @return string
     * @throws \Exception
     *
     */
    public function handle(array $widgetConf, HtmlPageCopilot $copilot): string;
}