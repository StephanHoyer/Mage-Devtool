Magento Devtool
===============

This module adds a toolbar to your Magento frontend based on jQuery UI. It currently includes the following features:

* Request information
* Extended Profiler (with sorting and filtering)
* Registry (Separated by session, helper and other data)
* Layout (Tree structure of the Layout)
* Session-Information
* Events fired of the current request

========= ===========================================================================
Author    Stephan Hoyer <stephan.hoyer@netresearch.de>
Copyright 2011 Netresearch GmbH & Co.KG <http://www.netresearch.de/>
License   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
Link      http://www.netresearch.de/leistungen/magento-ecommerce.html
========= ===========================================================================

Requirements
------------

The Devtool is tested on Magento 1.4.2.0 but may work on other versions of Magento. It is required to install the Jquery-Module from Mxperts

.. _Jquery-Module: http://www.magentocommerce.com/magento-connect/mxperts/extension/1619/mxperts--jquery-base

How to enable
-------------

After copying all files to your Magento installation, the described informations are easy accessible by a JS-UI. You can start the Devtool by attaching the GET-Parameter
::

 show-devtool=1
 
to any request. This setting is stored in your session. You can disable it by attaching the GET-Parameter

::

 show-devtool=0

Features in Detail
------------------

Request
+++++++

This tab shows basic information of the request. It is only skeleton at this stage. More data should be added here soon.

Profiler
++++++++

The profiler tab contains the normal Magento profiling information but within a JS-featured filter and order functionality.

Registry
++++++++

The registry tab does not contain any information if you do not add a additional function to your ``Mage``-class at ``Mage.php``. That means modifying the core. So be sure you know what you do.
::

 /**
  * Returns current registry array
  *
  * @return array
  */
 public static function getRegistry()
 {
     return self::$_registry;
 }

After adding this function, the tab contains all variables registered during this request. The registrations are separated by Singletons, Helpers and others.

Layout
++++++

The Layout tab contains the complete layout tree of the current visible page. The idea here is to extend this tab to see additional information for all the blocks that are rendered including the ones you can't see in the HTML output.

Session
+++++++

This Tab contains sub-tabs, each for every session. Here you can find all session data. Adding new tabs for your own session is easy: you simply add a new sub-block to the block called `devtool-session` like:
::

    <reference name="devtool-session">
        <block type="{YOUR_MODULE}/{YOUR_BLOCK}" name="devtool-session-{NAME}" template="devtool/session/abstract.phtml" as="{NAME}"/>
    </reference>

where {YOUR_BLOCK} has to extend `Mage_Devtool_Block_Session_Abstract`

Events
++++++

The events tab contains most of the events which where dispatched during the last request. You can click on each of them to get detailed information about which data the event comes with. You can also find the config xml-code you have to include in your config.xml to attach to this event.
 
Features and improvements to come
---------------------------------

Request
+++++++

Detailed information about the request and the response incl. headers, GET and POST parameters and much more.

Profiler
++++++++

The layout and CSS of the profiler table has to be improved to fit into the rest of the UI.  

Layout
++++++

There are a lot of ideas to extend the layout tab
* Detailed information on each block (Alias, template, class, cache status)
* XML to rewrite the block
* XML to attach the block as children of another
* Buttons to clear the blocks cache

Session
+++++++

The Session tab should also give the possibility to manipulate (edit/delete) the session information. Therefore we have to improve the security of the module. It must not be possible to take other ones identity by manipulation of the session data. The toolbar itself should be available only for authorized people (e.g. depending an admin session incl. ACL)

Events
++++++

The events tab should be extended to also show all observes which are attached to this event.

NEW TAB Inline Log
++++++++++++++++++

One tab should contain all log entries which were logged by Mage::log() during this request.

NEW TAB Clear Cache
+++++++++++++++++++

It should be possible to clear any of the caches with a click on specified buttons.

UI-Improvements
+++++++++++++++

* Different Icons for different types of nodes in a tree view (Object, Array, Scalar)
* Search field for all trees
* Resizeable toolbar

Extend printr() helper function
+++++++++++++++++++++++++++++

* Extend to print objects regarding the class
* Also include no-data-array member variables
* Also printr objects that don't inherit from Varien Object (e.g. controllers)

External Devtool
++++++++++++++++

It will be not always possible to show each information in the toolbar. Some require more space. The toolbar also does not work, in case there is a JavaScript error on the page. A solution for this might be a Devtool which runs on separate browser window or tab. So the toolbar could contain a link to open in a separate tab which is attached to the session. There you can build a AJAX-rich UI which refreshes automatically when the content in the main browser-window is changing.