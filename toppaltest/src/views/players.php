
<body>
<div id="main">


<h1>Demo</h1>

<table id="tablesorter-demo" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
    <thead>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Age</th>
        <th>Total</th>
        <th>Discount</th>
        <th>Difference</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Peter</td>
        <td>Parker</td>
        <td>28</td>
        <td>$9.99</td>
        <td>20.9%</td>
        <td>+12.1</td>
        <td>Jul 6, 2006 8:14 AM</td>
    </tr>
    <tr>
        <td>John</td>
        <td>Hood</td>
        <td>33</td>
        <td>$19.99</td>
        <td>25%</td>
        <td>+12</td>
        <td>Dec 10, 2002 5:14 AM</td>
    </tr>
    <tr>
        <td>Clark</td>
        <td>Kent</td>
        <td>18</td>
        <td>$15.89</td>
        <td>44%</td>
        <td>-26</td>
        <td>Jan 12, 2003 11:14 AM</td>
    </tr>
    <tr>
        <td>Bruce</td>
        <td>Almighty</td>
        <td>45</td>
        <td>$153.19</td>
        <td>44.7%</td>
        <td>+77</td>
        <td>Jan 18, 2001 9:12 AM</td>
    </tr>
    <tr>
        <td>Bruce</td>
        <td>Evans</td>
        <td>22</td>
        <td>$13.19</td>
        <td>11%</td>
        <td>-100.9</td>
        <td>Jan 18, 2007 9:12 AM</td>
    </tr>
    <tr>
        <td>Bruce</td>
        <td>Evans</td>
        <td>22</td>
        <td>$13.19</td>
        <td>11%</td>
        <td>0</td>
        <td>Jan 18, 2007 9:12 AM</td>
    </tr>
    </tbody>
</table>

<!--<p class="tip">-->
<!--<em>TIP!</em> Sort multiple columns simultaneously by holding down the shift key and clicking a second, third or even fourth column header!-->
<!--</p>	-->
<!---->
<!---->
<!--<a name="Getting-Started"></a>-->
<!--<h1>Getting started</h1>-->
<!--<p>-->
<!--To use the tablesorter plugin, include the <a class="external" href="http://jquery.com">jQuery</a>-->
<!--library and the tablesorter plugin inside the <code>&lt;head&gt;</code> tag-->
<!--of your HTML document:-->
<!--</p>-->
<!---->
<!--<pre class="javascript">-->
<!--&lt;script type=&quot;text/javascript&quot; src=&quot;/path/to/jquery-latest.js&quot;&gt;&lt;/script&gt;-->
<!--&lt;script type=&quot;text/javascript&quot; src=&quot;/path/to/jquery.tablesorter.js&quot;&gt;&lt;/script&gt;-->
<!--</pre>-->


<!--<p>tablesorter works on standard HTML tables.  You must include THEAD and TBODY tags:</p>-->
<!---->
<!--<pre class="html">-->
<!--&lt;table id="myTable" class="tablesorter"&gt;-->
<!--&lt;thead&gt;-->
<!--&lt;tr&gt;-->
<!--&lt;th&gt;Last Name&lt;/th&gt;-->
<!--&lt;th&gt;First Name&lt;/th&gt;-->
<!--&lt;th&gt;Email&lt;/th&gt;-->
<!--&lt;th&gt;Due&lt;/th&gt;-->
<!--&lt;th&gt;Web Site&lt;/th&gt;-->
<!--&lt;/tr&gt;-->
<!--&lt;/thead&gt;-->
<!--&lt;tbody&gt;-->
<!--&lt;tr&gt;-->
<!--&lt;td&gt;Smith&lt;/td&gt;-->
<!--&lt;td&gt;John&lt;/td&gt;-->
<!--&lt;td&gt;jsmith@gmail.com&lt;/td&gt;-->
<!--&lt;td&gt;$50.00&lt;/td&gt;-->
<!--&lt;td&gt;http://www.jsmith.com&lt;/td&gt;-->
<!--&lt;/tr&gt;-->
<!--&lt;tr&gt;-->
<!--&lt;td&gt;Bach&lt;/td&gt;-->
<!--&lt;td&gt;Frank&lt;/td&gt;-->
<!--&lt;td&gt;fbach@yahoo.com&lt;/td&gt;-->
<!--&lt;td&gt;$50.00&lt;/td&gt;-->
<!--&lt;td&gt;http://www.frank.com&lt;/td&gt;-->
<!--&lt;/tr&gt;-->
<!--&lt;tr&gt;-->
<!--&lt;td&gt;Doe&lt;/td&gt;-->
<!--&lt;td&gt;Jason&lt;/td&gt;-->
<!--&lt;td&gt;jdoe@hotmail.com&lt;/td&gt;-->
<!--&lt;td&gt;$100.00&lt;/td&gt;-->
<!--&lt;td&gt;http://www.jdoe.com&lt;/td&gt;-->
<!--&lt;/tr&gt;-->
<!--&lt;tr&gt;-->
<!--&lt;td&gt;Conway&lt;/td&gt;-->
<!--&lt;td&gt;Tim&lt;/td&gt;-->
<!--&lt;td&gt;tconway@earthlink.net&lt;/td&gt;-->
<!--&lt;td&gt;$50.00&lt;/td&gt;-->
<!--&lt;td&gt;http://www.timconway.com&lt;/td&gt;-->
<!--&lt;/tr&gt;-->
<!--&lt;/tbody&gt;-->
<!--&lt;/table&gt;-->
<!--</pre>-->


<!--<p>Start by telling tablesorter to sort your table when the document is loaded:</p>-->
<!---->
<!---->
<!---->
<!---->
<!--<pre class="javascript">-->
<!--$(document).ready(function()-->
<!--{-->
<!--$("#myTable").tablesorter();-->
<!--}-->
<!--);-->
<!--</pre>-->
<!---->
<!--<p>-->
<!--Click on the headers and you'll see that your table is now sortable!  You can -->
<!--also pass in configuration options when you initialize the table.  This tells-->
<!--tablesorter to sort on the first and second column in ascending order.-->
<!--</p>-->



<!--<pre class="javascript">-->
<!--$(document).ready(function()-->
<!--{-->
<!--$("#myTable").tablesorter( {sortList: [[0,0], [1,0]]} );-->
<!--}-->
<!--);-->
<!--</pre>-->
<!---->
<!--<p class="tip">-->
<!--<em>NOTE!</em> tablesorter will auto-detect most data types including numbers, dates, ip-adresses for more information see <a href="#Examples">Examples</a>-->
<!--</p>-->
<!---->
<!---->
<!---->


<!--<a name="Examples"></a>-->
<!--<h1>Examples</h1>-->
<!--<p>	-->
<!--These examples will show what's possible with tablesorter.  You need Javascript enabled to -->
<!--run these samples, just like you and your users will need Javascript enabled to use tablesorter.-->
<!--</p>-->
<!---->
<!--<strong>Basic</strong>-->
<!--<ul>-->
<!--<li><a href="example-option-sort-list.html">Set a initial sorting order using options</a></li>-->
<!--<li><a href="example-option-digits.html">Dealing with digits!</a></li>-->
<!--<li><a href="example-options-headers.html">Disable header using options</a></li>-->
<!--<li><a href="example-trigger-sort.html">Sort table using a link outside the table</a></li>	-->
<!--<li><a href="example-option-sort-force.html">Force a default sorting order</a></li>-->
<!--<li><a href="example-option-sort-key.html">Change the default multi-sorting key</a></li>	-->
<!--</ul>-->
<!--<strong>Metadata - setting inline options</strong>-->
<!--<ul>-->
<!--<li><a href="example-meta-sort-list.html">Set a initial sorting order using metadata</a></li>-->
<!--<li><a href="example-meta-headers.html">Disable header using metadata</a></li>-->
<!--<li><a href="example-meta-parsers.html">Setting column parser using metadata</a></li>-->
<!--</ul>	-->
<!---->
<!--<strong>Advanced</strong>-->
<!--<ul>-->
<!--<li><a href="example-triggers.html">Triggers sortEnd and sortStart(Displaying sorting progress)</a></li>		-->
<!--<li><a href="example-ajax.html">Appending table data with ajax</a></li>-->
<!--<li><a href="example-empty-table.html">Initializing tablesorter on a empty table</a></li>-->
<!--<li><a href="example-option-text-extraction.html">Dealing with markup inside cells</a></li>-->
<!--<li><a href="example-extending-defaults.html">Extending default options</a></li>-->
<!--<li><a href="example-option-debug.html">Enableing debug mode</a></li>-->
<!--<li><a href="example-parsers.html">Parser, writing your own</a></li>-->
<!--<li><a href="example-widgets.html">Widgets, writing your own</a></li>-->
<!--</ul>-->
<!---->
<!--<strong>Companion plugins</strong>-->
<!--<ul>-->
<!--<li><a href="example-pager.html">Pager plugin</a></li>-->
<!--</ul>	-->
<!---->
<!---->

<!---->


<!--<a name="Configuration"></a>-->
<!--<h1>Configuration</h1>-->

<!--<p>-->
<!--tablesorter has many options you can pass in at initialization to achieve different effects:-->
<!--</p>-->
<!---->


<!--<table id="options" class="tablesorter" border="0" cellpadding="0" cellspacing="1">-->
<!--<thead>-->
<!--<tr>-->
<!--<th>Property</th>-->
<!--<th>Type</th>-->
<!--<th>Default</th>-->
<!--<th>Description</th>-->
<!--<th>Link</th>-->
<!--</tr>-->
<!--</thead>-->
<!--<tbody>-->
<!--<tr>-->
<!--<td>sortList</td>-->
<!--<td>Array</td>-->
<!--<td>null</td>-->
<!--<td>An array of instructions for per-column sorting and direction in the format: <code>[[columnIndex, sortDirection], ... ]</code> where columnIndex is a zero-based index for your columns left-to-right and sortDirection is 0 for Ascending and 1 for Descending.  A valid argument that sorts ascending first by column 1 and then column 2 looks like: <code>[[0,0],[1,0]]</code></td>-->
<!--<td><a href="example-option-sort-list.html">Example</a></td>-->
<!--</tr>-->
<!--&lt;!&ndash; -->
<!--<tr>-->
<!--<td>sortInitialOrder</td>-->
<!--<td>String</td>-->
<!--<td>asc</td>-->
<!--<td>When clicking the header for the first time, the direction it sorts.  Valid arguments are "asc" for Ascending or "desc" for Descending.</td>-->
<!--<td><a href="example-option-sort-order.html">Example</a></td>-->
<!--</tr>-->
<!--&ndash;&gt;-->
<!--<tr>-->
<!--<td>sortMultiSortKey</td>-->
<!--<td>String</td>-->
<!--<td>shiftKey</td>-->
<!--<td>The key used to select more than one column for multi-column sorting.  Defaults to the shift key.  Other options might be ctrlKey, altKey. <br/>Reference: <a class="external" href="http://developer.mozilla.org/en/docs/DOM:event#Properties">http://developer.mozilla.org/en/docs/DOM:event#Properties</a></td>-->
<!---->
<!--<td><a href="example-option-sort-key.html">Example</a></td>-->
<!--</tr>-->
<!--<tr>-->
<!--<td>textExtraction</td>-->
<!--<td>String Or Function</td>-->
<!--<td>simple</td>-->
<!--<td>-->
<!--Defines which method is used to extract data from a table cell for sorting.  -->
<!--Built-in options include "simple" and "complex".  Use complex if you have data marked up -->
<!--inside of a table cell like: <code>&lt;td&gt;&lt;strong&gt;&lt;em&gt;123 Main Street&lt;/em&gt;&lt;/strong&gt;&lt;/td&gt;</code>.  -->
<!--Complex can be slow in large tables so consider writing your own text extraction function "myTextExtraction" which you define like:-->
<!--<pre class="javascript">-->
<!--var myTextExtraction = function(node) -->
<!--{ -->
<!--// extract data from markup and return it -->
<!--return node.childNodes[0].childNodes[0].innerHTML;-->
<!--}-->
<!--$(document).ready(function()-->
<!--{-->
<!--$("#myTable").tableSorter( {textExtraction: myTextExtraction} );-->
<!--}-->
<!--);-->
<!--</pre>  -->

<!--tablesorter will pass a jQuery object containing the contents of the current cell for you to parse and return.  Thanks to Josh Nathanson for the examples.-->
<!--</td>-->
<!--<td><a href="example-option-text-extraction.html">Example</a></td>-->
<!--</tr>-->
<!--<tr>-->
<!--<td>headers</td>-->
<!--<td>Object</td>-->
<!--<td>null</td>-->
<!--<td>-->
<!--An object of instructions for per-column controls in the format: <code>headers: { 0: { option: setting }, ... }</code>  For example, to disable -->
<!--sorting on the first two columns of a table: <code>headers: { 0: { sorter: false}, 1: {sorter: false} }</code>-->
<!--</td>-->
<!--<td><a href="example-options-headers.html">Example</a></td>-->
<!--</tr>-->
<!--<tr>-->
<!--<td>sortForce</td>-->
<!--<td>Array</td>-->
<!--<td>null</td>-->
<!--<td>Use to add an additional forced sort that will be appended to the dynamic selections by the user.  For example, can be used to sort people alphabetically after some other user-selected sort that results in rows with the same value like dates or money due.  It can help prevent data from appearing as though it has a random secondary sort.</td>-->
<!--<td><a href="example-option-sort-force.html">Example</a></td>-->
<!--</tr>-->
<!--<tr>-->
<!--<td>widthFixed</td>-->
<!--<td>Boolean</td>-->
<!--<td>false</td>-->
<!--<td>Indicates if tablesorter should apply fixed widths to the table columns.  This is useful for the Pager companion.  Requires the <a href="#Download-Addons">jQuery dimension plugin</a> to work.</a></td>-->
<!--<td><a href="example-pager.html">Example</a></td>-->
<!--</tr>-->
<!--<tr>-->
<!--<td>cancelSelection</td>-->
<!--<td>Boolean</td>-->
<!--<td>true</td>-->
<!--<td>Indicates if tablesorter should disable selection of text in the table header (TH).  Makes header behave more like a button.</td>-->
<!--<td></td>-->
<!--</tr>-->
<!--<tr>-->
<!--<td>cssHeader</td>-->
<!--<td>String</td>-->
<!--<td>"header"</td>-->
<!--<td>The CSS style used to style the header in its unsorted state.  Example from the blue skin:-->
<!--<pre class="css">-->
<!--th.header {-->
<!--background-image: url(../img/small.gif);	-->
<!--cursor: pointer;-->
<!--font-weight: bold;-->
<!--background-repeat: no-repeat;-->
<!--background-position: center left;-->
<!--padding-left: 20px;-->
<!--border-right: 1px solid #dad9c7;-->
<!--margin-left: -1px;-->
<!--}-->
<!--</pre>        	-->
<!--</td>-->
<!--<td></td>-->
<!--</tr>-->
<!--<tr>-->
<!--<td>cssAsc</td>-->
<!--<td>String</td>-->
<!--<td>"headerSortUp"</td>-->
<!--<td>The CSS style used to style the header when sorting ascending.  Example from the blue skin:-->
<!--<pre class="css">-->
<!--th.headerSortUp {-->
<!--background-image: url(../img/small_asc.gif);-->
<!--background-color: #3399FF;-->
<!--}-->
<!--</pre>-->
<!--</td>-->
<!--<td></td>-->
<!--</tr>-->
<!--<tr>-->
<!--<td>cssDesc</td>-->
<!--<td>String</td>-->
<!--<td>"headerSortDown"</td>-->
<!--<td>The CSS style used to style the header when sorting descending.  Example from the blue skin:-->
<!--<pre  class="css">-->
<!--th.headerSortDown {-->
<!--background-image: url(../img/small_desc.gif);-->
<!--background-color: #3399FF;-->
<!--}-->
<!--</pre>-->
<!--</td>-->
<!--<td></td>-->
<!--</tr>-->
<!--<tr>-->
<!--<td>debug</td>-->
<!--<td>Boolean</td>-->
<!--<td>false</td>-->
<!--<td>-->
<!--Boolean flag indicating if tablesorter should display debuging information usefull for development.-->
<!--</td>-->
<!--<td><a href="example-option-debug.html">Example</a></td>-->
<!--</tr>-->
<!--</tbody>-->
<!--</table>-->
<!---->
<!---->
<!---->
<!--<a name="Download"></a>-->
<!--<h1>Download</h1>-->
<!---->
<!--<p><strong>Full release</strong> - Plugin, Documentation, Add-ons, Themes <a href="../jquery.tablesorter.zip">jquery.tablesorter.zip</a></p>-->
<!---->
<!---->
<!--<p><strong>Pick n choose</strong> - Place at least the required files in a directory on your webserver that is accessible to a web browser.  Record this location.</p>-->
<!---->
<!--<strong id="Download-Required">Required:</strong>-->
<!--<ul>-->
<!--<li><a class="external" href="http://docs.jquery.com/Downloading_jQuery#Download_jQuery">jQuery</a> (1.2.1 or higher)</li>-->
<!--<li><a href="../jquery.tablesorter.min.js">jquery.tablesorter.min.js</a> (12kb, Minified for production)</li>-->
<!--</ul>  -->
<!---->
<!--<strong id="Download-Addons">Optional/Add-Ons:</strong>-->
<!--<ul>-->
<!--<li><a class="external" href="http://jquery.com/dev/svn/trunk/plugins/metadata/lib/jQuery/metadata.js?format=raw">metadata.js</a> (3,7kb <strong>Required for setting <a href="#Examples">inline options</a></strong>)</li>-->
<!--&lt;!&ndash;-->
<!--<li><a class="external" href="http://dev.jquery.com/browser/trunk/plugins/dimensions/jquery.dimensions.-->
<!--.js?format=raw">jquery.dimensions.pack.js</a> (5,1kb, <a href="http://dean.edwards.name/packer/" class="external">packed</a>, for production. <strong>Required: for the <a href="example-pager.html">tablesorter pagination plugin</a></strong>)</li>-->
<!--&ndash;&gt;-->
<!--<li><a href="../jquery.tablesorter.js">jquery.tablesorter.js</a> (17,7kb, for development)</li>-->
<!--<li><a href="../addons/pager/jquery.tablesorter.pager.js">jquery.tablesorter.pager.js</a> (3,6kb, <a href="example-pager.html">tablesorter pagination plugin</a>)</li>-->
<!--</ul>  -->
<!---->
<!--<strong id="Download-Widgets">Widgets:</strong>-->
<!--<ul>-->
<!--<li><a class="external" href="http://www.jdempster.com/category/code/jquery/tablesortercookiewidget/">Cookie Widget</a>, By <a class="external" href="http://www.jdempster.com/">James Dempster</a></li>-->
<!--</ul> -->
<!---->
<!--<strong id="Download-Themes">Themes:</strong>-->
<!--<ul>-->
<!--<li><a href="../themes/green/green.zip">Green Skin</a> - Images and CSS styles for green themed headers</li>-->
<!--<li><a href="../themes/blue/blue.zip">Blue Skin</a> - Images and CSS styles for blue themed headers (as seen in the examples)</li>-->
<!--</ul>  	-->

<!--<a name="Compatibility"></a>-->
<!--<h1>Browser Compatibility</h1>-->

<!--<p>tablesorter has been tested successfully in the following browsers with Javascript enabled:</p>-->
<!--<ul>-->
<!--<li>Firefox 2+</li>-->
<!--<li>Internet Explorer 6+</li>-->
<!--<li>Safari 2+</li>-->
<!--<li>Opera 9+</li>-->
<!--<li>Konqueror</li>-->
<!--</ul>-->
<!---->
<!--<p><a class="external" href="http://docs.jquery.com/Browser_Compatibility">jQuery Browser Compatibility</a></p>-->
<!---->
<!---->


<!--<a name="Support"></a>-->
<!--<h1>Support</h1>-->
<!--<p>-->
<!--Support is available through the-->
<!--<a class="external" href="http://jquery.com/discuss/">jQuery Mailing List</a>.  -->
<!--</p>      -->
<!--<p>Access to the jQuery Mailing List is also available through <a class="external" href="http://www.nabble.com/JQuery-f15494.html">Nabble Forums</a>.</p>-->


<!--<a name="Credits"></a>-->
<!--<h1>Credits</h1>-->
<!--<p>-->
<!--Written by <a class="external" href="http://lovepeacenukes.com">Christian Bach</a>.-->
<!--</p>-->
<!--<p>-->
<!--Documentation written by <a class="external" href="http://www.ghidinelli.com">Brian Ghidinelli</a>, -->
<!--based on <a class="external" href="http://malsup.com/jquery/">Mike Alsup's</a> great documention.-->
<!--</p>-->
<!--<p>-->
<!--<a class="external" href="http://ejohn.org">John Resig</a> for the fantastic <a class="external" href="http://jquery.com">jQuery</a>		-->
<!--</p>-->
<!--</div>-->

<!--<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>-->
<!--<script type="text/javascript">-->
<!--_uacct = "UA-2189649-2";-->
<!--urchinTracker();-->
<!--</script>-->
</body>
</html>

