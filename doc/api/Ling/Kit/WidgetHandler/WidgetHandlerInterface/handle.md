[Back to the Ling/Kit api](https://github.com/lingtalfi/Kit/blob/master/doc/api/Ling/Kit.md)<br>
[Back to the Ling\Kit\WidgetHandler\WidgetHandlerInterface class](https://github.com/lingtalfi/Kit/blob/master/doc/api/Ling/Kit/WidgetHandler/WidgetHandlerInterface.md)


WidgetHandlerInterface::handle
================



WidgetHandlerInterface::handle — Returns the html code of the widget, according to the widget configuration.




Description
================


abstract public [WidgetHandlerInterface::handle](https://github.com/lingtalfi/Kit/blob/master/doc/api/Ling/Kit/WidgetHandler/WidgetHandlerInterface/handle.md)(array $widgetConf, [Ling\HtmlPageTools\Copilot\HtmlPageCopilot](https://github.com/lingtalfi/HtmlPageTools/blob/master/doc/api/Ling/HtmlPageTools/Copilot/HtmlPageCopilot.md) $copilot) : string




Returns the html code of the widget, according to the widget configuration.
If the widget uses some assets, or use some js code block, it also registers them to the given copilot.

For more info about the copilot, see the [HtmlPageCopilot documentation](https://github.com/lingtalfi/HtmlPageTools/blob/master/doc/api/Ling/HtmlPageTools/Copilot/HtmlPageCopilot.md).

If something goes wrong, the widget should throw an exception.




Parameters
================


- widgetConf

    

- copilot

    


Return values
================

Returns string.


Exceptions thrown
================

- [Exception](http://php.net/manual/en/class.exception.php).&nbsp;







See Also
================

The [WidgetHandlerInterface](https://github.com/lingtalfi/Kit/blob/master/doc/api/Ling/Kit/WidgetHandler/WidgetHandlerInterface.md) class.



