var TextInserts = (function ($) {
    // Place your administration-specific JavaScript here
    var ml = {};

    ml.eClicked = null;
    
    ml.addHookBox = function () {
        var hb = document.createElement('div');
        hb.className = 'hook-box';

        hb.innerHTML = '<div class="hb-upper-wrapper">\
                            <div class="hb-options-div">\
                                <span>Box Name</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[OPTIONAL] An arbitrary name for this box.">?</span><br>\
                                <input type="text" name="name" class="name" /><br><br>\
                                <span>Hook</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[REQUIRED] The hook slug where the text/html content will be inserted.<br><br>If you are using the <strong>Thesis 2.1</strong> theme, you can use the hooks detailed here: <a href=&quot;http://diythemes.com/thesis/rtfm/tutorials/hooks/&quot; target=&quot;_blank&quot;>Thesis 2 Hook Syntax</a>.<br><br>If you are using the <strong>Genesis</strong> theme, you can use the hooks detailed here: <a href=&quot;http://my.studiopress.com/docs/hook-reference/#structural-action-hooks&quot; target=&quot;_blank&quot;>Structural Action Hooks</a>.<br><br>You can also view all available Genesis/Thesis 2 hooks <a href=&quot;'+ localized.hooks_url +'&quot; target=&quot;_blank&quot;>here</a>.<br><br><i>Note that the hooks beginning with <strong>hook_</strong> in the default list are Thesis hooks.</i>">?</span><br>\
                                <input type="text" list="hooks-list" name="hook" class="hook" onkeydown="this.dataset.valid=false" onkeyup="TextInserts.validateHook(this)" data-valid="false" /><br><br>\
                                <datalist id="hooks-list">\
                                    <option value="hook_before_container">\
                                    <option value="hook_before_header">\
                                    <option value="hook_before_columns">\
                                    <option value="hook_before_content">\
                                    <option value="hook_before_post_box">\
                                    <option value="hook_before_sidebar">\
                                    <option value="hook_before_footer">\
                                    <option value="genesis_before_header">\
                                    <option value="genesis_header">\
                                    <option value="genesis_after_header">\
                                    <option value="genesis_before_content">\
                                    <option value="genesis_after_content">\
                                    <option value="genesis_before_sidebar_widget_area">\
                                    <option value="genesis_after_sidebar_widget_area">\
                                </datalist>\
                                <span>Show in</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[REQUIRED] Whether to show this box in posts, pages, both or only in the homepage.">?</span><br>\
                                <select name="display" class="display">\
                                    <option value="1" selected="selected" >posts &amp; pages</option>\
                                    <option value="2" >posts only</option>\
                                    <option value="3" >pages only</option>\
                                    <option value="4" >homepage only</option>\
                                    <option value="5" >everywhere</option>\
                                </select><br><br>\
                            <span>Filtering Method</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="Filter by including/excluding post/page IDs.">?</span><br>\
                            <select name="filtering" class="filtering">\
                                <option value="1" selected="selected">none</option>\
                                <option value="2">exclude all except</option>\
                                <option value="3">include all except</option>\
                            </select><br><br>\
                            <span>Filtered IDs</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[OPTIONAL] Comma-delimited list of post/page IDs.">?</span><br>\
                            <input type="text" name="filtered-ids" class="filtered-ids" value="" /><br><br>\
                                <span>Priority</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[REQUIRED] The lower the number, the higher the priority. Only change this if you know what action/filter priority is.">?</span><br>\
                                <input type="text" name="priority" class="priority" value="11" />\
                            </div>\
                            <div class="hb-txt-div">\
                                <span>Text / HTML</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[REQUIRED] The text/html content to be inserted.">?</span><br>\
                                <textarea class="hb-txt-contentarea"></textarea>\
                            </div>\
                            <div class="clear-fix"></div>\
                        </div>\
                        <div class="hb-lower-wrapper">\
                            <input type="checkbox" name="enabled" class="enabled" value="1" checked="checked" /><span>Enable</span>\
                            <span class="rem-parent">\
                                <span class="remove-txt" onclick="TextInserts.displayRemoveConf(this)">Remove</span>\
                            </span>\
                        </div>';
        
        document.getElementById('hook-boxes').appendChild(hb);
    };

    ml.addContentBox = function () {
        var cb = document.createElement('div');
        cb.className = 'content-box';

        cb.innerHTML = '<div class="cb-upper-wrapper">\
                            <div class="cb-options-div">\
                                <span>Box Name</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[OPTIONAL] An arbitrary name for this box.">?</span><br>\
                                <input type="text" name="name" class="name" /><br><br>\
                                <span>Show in</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[REQUIRED] Whether to show this box in posts, pages or both.">?</span><br>\
                                <select name="display" class="display">\
                                    <option value="1" selected="selected">posts &amp; pages</option>\
                                    <option value="2">posts only</option>\
                                    <option value="3">pages only</option>\
                                </select><br><br>\
                                <span>Filtering Method</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="Filter by including/excluding post/page IDs.">?</span><br>\
                                <select name="filtering" class="filtering">\
                                    <option value="1" selected="selected">none</option>\
                                    <option value="2">exclude all except</option>\
                                    <option value="3">include all except</option>\
                                </select><br><br>\
                                <span>Filtered IDs</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[OPTIONAL] Comma-delimited list of post/page IDs.">?</span><br>\
                                <input type="text" name="filtered-ids" class="filtered-ids" value="" /><br><br>\
                                <span>Insertion Method</span> <span class="tooltip ins-tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="Text/html will be inserted after the nth paragraph.">?</span><br>\
                                <select name="method" class="method" onchange="TextInserts.changeInsMethodTooltip(this)">\
                                    <option value="1" data-tooltip="Text/html will be inserted after the nth paragraph." selected="selected">after nth paragraph</option>\
                                    <option value="2" data-tooltip="Text/html will be inserted after % of total paragraphs. <br><br>Example, if there are 6 paragraphs and 50 is supplied in the {Insertion Position} field, text/html will be inserted after 6 * 0.5 paragraphs, which is after the 3rd paragraph.">after % of total paragraphs</option>\
                                    <option value="3" data-tooltip="Text/html will be inserted at {position}. Where {position} can be:<br><br>  <ul><li>before the content</li><li>after the content</li><li>before first paragraph</li><li>after the last paragraph</li></ul>">at position</option>\
                                </select><br><br>\
                                <span>Insertion Position</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="Where the text/html will be inserted into the content.">?</span><br>\
                                <span class="position-wrap">\
                                    <input type="number" name="position" class="position" min="1" value="1" />\
                                </span><br><br>\
                                <span>Priority</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[REQUIRED] The lower the number, the higher the priority. Only change this if you know what action/filter priority is.">?</span><br>\
                                <input type="text" name="priority" class="priority" value="11" />\
                            </div>\
                            <div class="cb-txt-div">\
                                <span>Text / HTML</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[REQUIRED] The text/html content to be inserted.">?</span><br>\
                                <textarea class="cb-txt-contentarea"></textarea>\
                            </div>\
                            <div class="clear-fix"></div>\
                        </div>\
                        <div class="cb-lower-wrapper">\
                            <input type="checkbox" name="enabled" class="enabled" value="1" checked="checked" /><span>Enable</span>\
                            <span class="rem-parent">\
                                <span class="remove-txt" onclick="TextInserts.displayRemoveConf(this)">Remove</span>\
                            </span>\
                        </div>';

        document.getElementById('content-boxes').appendChild(cb);
    };

    ml.validateHook = function (obj) {
        obj.value = obj.value.trim(); // trim leading/trailing whitespace

        var value = obj.value;
        if (value !== '' && value.split(' ').join('').length === value.length) {
            obj.dataset.valid = 'true';
            obj.style.borderColor = '#ddd';

        }
        else {
            obj.dataset.valid = 'false';
            obj.style.borderColor = 'red';
        }
    };

    ml.displayRemoveConf = function (obj) {
        //obj.getElementsByClassName('rem-conf-line')[0].style.display = 'inline';
        obj.parentNode.innerHTML = '<span style="float: right; margin-right: 12px;" class="rem-conf-line">Do you really wish to remove this box? <span class="action-txt" onclick="TextInserts.removeBox(this)">YES</span> / <span class="action-txt" onclick="TextInserts.removeConf(this)">NO</span></span>';
    };

    ml.removeBox = function (obj) {
        obj.parentNode.parentNode.parentNode.parentNode.remove();
    };

    ml.removeConf = function (obj) {
        obj.parentNode.parentNode.innerHTML = '<span class="remove-txt" onclick="TextInserts.displayRemoveConf(this)">Remove</span';
    };

    // consolidates all the form data and converts it into a json string
    ml.consolidateData = function () {
        var hb_data = [], cb_data = [], error_count = 0,
            datasect, settings, data;

        // consolidate hook box data
        var hb_boxes = document.getElementById('hook-boxes').getElementsByClassName('hook-box');
        for (var i = 0; i < hb_boxes.length; i++) {
            datasect = hb_boxes[i].getElementsByClassName('hb-upper-wrapper')[0];
            settings = datasect.getElementsByClassName('hb-options-div')[0];
            data = {
                name          : escape(settings.getElementsByClassName('name')[0].value),
                hook          : settings.getElementsByClassName('hook')[0].value,
                display       : settings.getElementsByClassName('display')[0].value,
                filtering     : settings.getElementsByClassName('filtering')[0].value,
                filtered_list : settings.getElementsByClassName('filtered-ids')[0].value.replace(' ', ''),
                priority      : settings.getElementsByClassName('priority')[0].value,
                text          : escape(datasect.getElementsByClassName('hb-txt-div')[0].getElementsByClassName('hb-txt-contentarea')[0].value),
                enabled       : hb_boxes[i].getElementsByClassName('enabled')[0].checked
            };

            // check if valid hook is supplied and text/html content is not empty
            var thb = data.hook.split(' ').join('');
            if (data.hook.length === thb.length && thb.length > 0 && data.text.trim().length > 0) {
                hb_data.push(data);
            }
            else {
                error_count++;
            }
        }

        // consolidate content box data
        var cb_boxes = document.getElementById('content-boxes').getElementsByClassName('content-box');
        for (var i = 0; i < cb_boxes.length; i++) {
            datasect = cb_boxes[i].getElementsByClassName('cb-upper-wrapper')[0];
            settings = datasect.getElementsByClassName('cb-options-div')[0];
            data = {
                name 	      : escape(settings.getElementsByClassName('name')[0].value),
                display       : settings.getElementsByClassName('display')[0].value,
                filtering     : settings.getElementsByClassName('filtering')[0].value,
                filtered_list : settings.getElementsByClassName('filtered-ids')[0].value.replace(' ', ''),
                method 	      : settings.getElementsByClassName('method')[0].value,
                position      : settings.getElementsByClassName('position')[0].value,
                priority      : settings.getElementsByClassName('priority')[0].value,
                text 	      : escape(datasect.getElementsByClassName('cb-txt-div')[0].getElementsByClassName('cb-txt-contentarea')[0].value),
                enabled       : cb_boxes[i].getElementsByClassName('enabled')[0].checked
            };

            // check if valid hook is supplied and text/html content is not empty
            if (data.text.trim().length > 0) {
                cb_data.push(data);
            }
            else {
                error_count++;
            }
        }

        if (error_count > 0) {
            return false; // error encountered
        }

        document.getElementById('json_hb').value = ml.toPseudoJSON(hb_data);
        document.getElementById('json_cb').value = ml.toPseudoJSON(cb_data);

        return true;
    };

    // save settings
    ml.tiSaveChanges = function () {
        // save current active tab
        sessionStorage.setItem('txtins_currently_viewed_tab', document.getElementsByClassName('tl-active')[0].id);
    
        // first consolidate the data
        if (ml.consolidateData()) {
            // submit the form
            document.getElementById('txtins_form').submit();
        }
        else {
            // show error
            alert('Save Failed. Please fill-in all the required fields.')
        }
    };
    
    // Switch Tabs
    ml.switchTab = function (obj) {
        // remove the active class
        document.getElementsByClassName('tl-active')[0].className = '';

        // append active class to this tab
        obj.className = 'tl-active';

        // hide all tabs
        var tabs = document.getElementsByClassName('tl-tab');

        for (var i = 0, length = tabs.length; i < length; i++) {
            tabs[i].style.display = 'none';
        }

        // show this tab
        document.getElementById(obj.dataset.tab).style.display = 'block';
    };

    // custom json stringification function, takes an array of objects
    ml.toPseudoJSON = function (array) {
        var ps = '';
        
        if (array.length > 0) {
            ps = '[';

            for (var i = 0; i < array.length; i++) {
                ps += '{';
                    for (var key in array[i]) {
                        ps += '&quot;'+ key +'&quot;:';
                        if (typeof array[i][key] === 'string') {
                            ps += '&quot;'+array[i][key] +'&quot;,';
                        }
                        else {
                            ps += array[i][key] +',';
                        }
                        
                    }
                ps = ps.slice(0, -1); // strip the extra comma
                ps += '},';
            }
            ps = ps.slice(0, -1); // strip the extra comma
            ps += ']';
        }

        return ps;
    };

    // replaces double quotes in str into their html entity
    ml.doubleQuotesToEntity = function (str) {
        return str.split('"').join('&dbquot;');
    };

    // update tooltip for the insert method selection box
    ml.changeInsMethodTooltip = function (obj) {
        var val = obj.value;
        var opts = obj.getElementsByTagName('option');
        for (var i = 0; i < opts.length; i++) {
            if (opts[i].value === val) {
                obj.parentNode.getElementsByClassName('ins-tooltip')[0].dataset.tooltip = opts[i].dataset.tooltip;
                break;
            }
        }
        // change position options
        var optStr = '';

        if (val === '1') {
            optStr = '<input type="number" name="position" class="position" min="1" value="1" />';
        }
        else if (val === '2') {
            optStr = '<input type="number" name="position" class="position" min="1" max="100" value="1" />';
        }
        else if (val === '3') {
            optStr = '<select name="position" class="position">\
                        <option value="1" selected="selected">before the content</option>\
                        <option value="2">after the content</option>\
                        <option value="3">before the first paragraph</option>\
                        <option value="4">after the first paragraph</option>\
                      </select>';
        }

        obj.parentNode.getElementsByClassName('position-wrap')[0].innerHTML = optStr;
    };
    
    // Tooltips
    ml.displayTooltip = function (obj) {
        var text = obj.dataset.tooltip;
            text = text.replace('[REQUIRED]', '<span class="tooltip-required">REQUIRED</span>').replace('[OPTIONAL]', '<span class="tooltip-optional">OPTIONAL</span>');

        var tooltip = document.createElement('div');
        tooltip.className = 'tooltip-pop';
        tooltip.innerHTML = text;
        $(tooltip).mouseleave(function() {
            if (tooltip.parentNode !== document.activeElement) {
                tooltip.remove();
            }
        });

        obj.innerHTML = '?'; // reset contents to remove extra tooltip-pop elements
        obj.appendChild( tooltip );
    };
    
    ml.removeTooltip = function (obj) {
        // don't remove if the clicked element, its parent, or its grandparent is the tooltip-pop container
        if (ml.eClicked.className                       === 'tooltip-pop' ||
            ml.eClicked.parentNode.className            === 'tooltip-pop' ||
            ml.eClicked.parentNode.parentNode.className === 'tooltip-pop') {

            return;
        }

        obj.innerHTML = '?';
    };
    
    return ml;
}(jQuery));

jQuery(document).mousedown(function(e) {
    // The latest element clicked
    TextInserts.eClicked = e.target;
});

// switch tab onload
window.onload = function () {
    var activeTab = sessionStorage.getItem('txtins_currently_viewed_tab');
    activeTab = document.getElementById(activeTab);
    if (activeTab !== null) {
        TextInserts.switchTab(activeTab);
    }
};



