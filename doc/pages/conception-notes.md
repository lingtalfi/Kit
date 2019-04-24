Conception notes 
========
2019-04-24




* [The concepts used by Kit](#the-concepts-used-by-kit)
* [The kit configuration array](#the-kit-configuration-array)
 * [Comments](#comments)
 * [About type](#about-type)
* [A Babyyaml implementation of the kit configuration array](#a-babyyaml-implementation-of-the-kit-configuration-array)
* [Database vs BabyYaml?](#database-vs-babyyaml)
* [Going deeper with widgets: the picasso widget](#going-deeper-with-widgets-the-picasso-widget)
 * [A planet can provide multiple widgets](#a-planet-can-provide-multiple-widgets)
 * [Using templates](#using-templates)
 * [Using js-init files](#using-js-init-files)
 * [The picasso widget configuration array](#the-picasso-widget-configuration-array)
         
         
         

The concepts used by Kit
-------------

Kit is a system to render widgets in an html page.

It uses the following concepts:

- page
- layout
- zone
- widget



The page is the biggest container, it contains everything and represents an html page.

A page uses a layout, which is like the html skeleton of the page. 

A layout is a php file, which content looks like an html file, but which includes zones.


Note: the layout file also uses the [HtmlPageRenderer](https://github.com/lingtalfi/HtmlPageTools/blob/master/doc/api/Ling/HtmlPageTools/Renderer/HtmlPageRenderer.md) from the [HtmlPageTools planet](https://github.com/lingtalfi/HtmlPageTools) to
render the top and bottom of the html page. And so Kit borrows [the concept of top and bottom](https://github.com/lingtalfi/HtmlPageTools/blob/master/doc/api/Ling/HtmlPageTools/Renderer/HtmlPageRenderer.md#the-top-and-bottom-concept) too.


A zone is like a placeholder for widgets. The developer will attach widgets to a zone.
She can attach as many widgets as she wants.

And so, by assigning the widgets to the different zones of the layout, she composes the html page.


The widget is the smallest unit in Kit: it's an html code block representing an identifiable element on the html page.

For instance, a menu nav bar, or a list of blog posts, or an advertising in a side bar, ...


The kit configuration array
-------------

To actually render a page, we need to pass a configuration array to the KitPageRenderer object.

In this document, I will use the [BabyYaml](https://github.com/lingtalfi/BabyYaml) notation for representing arrays (for readability purpose).


Here is the configuration for a given page (variables are preceded with the dollar symbol):

```yaml

label: $pageLabel               # The human name for the page. It is used in error messages.                 
layout: $layoutRelPath          # The relative path to the layout file for this page. The path is relative to a root which shall be defined in the general configuration of kit.
layout_vars: []                 # an array of layout vars that will be accessible to the layout (a layout might be configured to some degree by such variables, depending on the layout)
zones:
    $zoneName:                  # note: the zone name is called from the layout file 
        -   
            name: $widgetName       # the widget name
            type: $widgetType       # the widget type
            ?active: $bool          # whether to use the widget, defaults to true
            ...                     # any other configuration value that you want 
            
```


### Comments

On a design level, I wanted us to be able to re-use zones from one page to the other.
And I first thought that the zones shall be configured at a more abstract level.
But after thinking again, I now believe that simplicity is the master, and so I define the zones in the page where they
belong, and re-using a zone will actually be a duplication performed by gui interfaces or other more sophisticated 
apis (sort of a courtesy tricks for the lazy humans that we are, but it should not corrupt the simplicity of my design).

And so with zones in the page configuration, yes, there will be code duplication, but in the end we will have a more robust 
and intuitive application (I believe).

The $zoneName array is a numerically indexed array, and the order of the elements in this array defines the order of the widgets
on the page. Note that the same widget can be used multiple times on the same zone (hence the use of a numerical array vs an array using
the widget names as the keys).



### About type

Now I hesitated before committing the type system.
The other option I was going for was a system where the page renderer would guess the widget type, using a WidgetHandler object
with a isHandled method.

Then I thought about the consequences in term of design.

The only benefit I could think of with a guessing system is that it saves us from typing an explicit type.

But at the same time, it makes the system more obscure/unpredictable, since the type is not explicit.

So, for the sake of the system robustness, I decided that I would go along with the explicit type, which is redundant and boring
to type, but at the same time participates to the robustness of the system.

Plus, since we don't need to guess, it's a little faster performance wise. 






A Babyyaml implementation of the kit configuration array
--------------

As we've seen, the kit configuration array represents a page.

If we use BabyYaml to store the array, we can simply create one configuration file per page, with the name of the configuration
file being the name of the page.

For instance, we could have a kit directory with the following structure:

```txt
- kit/
----- config.byml       # a general kit configuration file. Note: I'm not sure about that, maybe we don't need it.
----- pages/
--------- page_one.byml
--------- page_two.byml
--------- page_three.byml
```




Database vs BabyYaml?
---------
2019-04-24


Now unfortunately I don't have any answer to this question yet, as fas as which solution is faster/more efficient.

But I wanted to put down the question mark so that I don't forget.

I personally like babyYaml, being a developer, using the IDE all the time, so I'll start with that.

Later, I will implement a mysql version, to see if a system is better than the other.

 



Going deeper with widgets: the picasso widget
----------------

Now as I said earlier, a widget configuration depends on the widget.
I will create an implementation that corresponds to my needs, and I will name it Picasso, after the painter of the same name (don't ask me why),
just to pave the way and show that an infinite number of widget systems implementation are possible.

Now if you want to use the Picasso system, you're welcome.

The picasso system basically uses a php class and a file structure convention.

The php class must extend the PicassoWidget class, and must contain a widget directory right next to the php class, with the following structure:


```txt
- widget/
----- templates/            # this directory contains the templates available to this widget
--------- prototype.php     # just an example, can be any name really...
--------- default.php       # just an example, can be any name really...
----- js-init/
--------- default.js        # can be any name, but it's the same name as a template
```


So the main ideas here are:

- a [planet](https://github.com/karayabin/universe-snapshot) can provide multiple widgets
- the use of templates
- the use of js-init files


###  A planet can provide multiple widgets

When I say planet, I mean any container really, but the planet is a container.
And so the idea is that since we don't have the widget directory at the root of the planet (or container), the planet
can provide multiple widgets (not only one). 



### Using templates

I decided to use templates for two reasons:
 
- it's easy to switch from a template to another.
- I personally like the prototyping approach for creating websites, where you first inject the html from a template, 
        and then make it dynamic using php code injection, and so starting by creating a prototype template (by copy-pasting
        from the original template model) is a methodology that I promote. 

### Using js-init files

In the picasso approach, we like to put js scripts at the end of the html page, just before the closing body tag.
In there, we also put the js code for the widgets that need such initialization code.

The idea with the js-init files is that when the template is loaded, the initialization js code blocks are also automatically
loaded (via the use of the Copilot object from the [HtmlPageRenderer](https://github.com/lingtalfi/HtmlPageTools/blob/master/doc/api/Ling/HtmlPageTools/Renderer/HtmlPageRenderer.md)).

The main benefit of using js-init files is that we use js files, and so the writing of initialization code is easy (because
your IDE will provide you with the correct js syntax highlighting).

Now with this system, the js init file name must match the template name.

The benefit is:

- simple conception, easy to remember

One drawback is:

- we don't have a fancy common.js file that would be called for every template for instance

But as always, I tend to prefer simple things over fancy ones, so I opted for the first mechanism (at least for now). 


### The picasso widget configuration array

So, here is the configuration array for the picasso widget:

```yaml
className: $theClassName        # for instance Ling\MyFirstPicassoWidget\MyFirstPicassoWidget 
template: $templateName         # for instance: default.php, or prototype.php. This is the path to the template file, relative to the widget/templates directory of the planet.
``` 


Again: I could drop the file extension in the name, to save us four characters per widget configuration array,
but I believe it's not worth it. 
Because today I use php extension, but I don't know about tomorrow.



Now since Picasso is the first widget system, I believe I will include it with Kit, so that the newbie user doesn't have to
fetch for a Picasso planet when she doesn't even know about kit (hopefully this is not a design flaw right there).
Actually you know what, I won't include it in Kit, because Kit is already complex enough by itself.