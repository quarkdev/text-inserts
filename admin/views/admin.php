<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Text_Inserts
 * @author    Roosdoring Inc <roosdoring@hotmail.com>
 * @license   GPL-2.0+
 * @link      http://www.thephysicalaffiliate.com/
 * @copyright 2014 Roosdoring Inc
 */
?>

<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<!-- @TODO: Provide markup for your options page here. -->
	<form id="txtins_form" method="post" action="options.php">
		<?php settings_fields( 'txtins_group' ); ?>
		<?php do_settings_sections( 'txtins_group' ); ?>
		<p><input type="button" class="button button-primary" onclick="TextInserts.tiSaveChanges()" value="Save Changes" /></p>

		<input type="hidden" name="txtins_hook_boxes" id="json_hb" value="" />
		<input type="hidden" name="txtins_content_boxes" id="json_cb" value="" />

        <ul id="tabbed-links">
        	<li id="tl-1" class="tl-active" onclick="TextInserts.switchTab(this)" data-tab="hook-box-div">Hook Boxes</li><!--
        	--><li id="tl-2" onclick="TextInserts.switchTab(this)" data-tab="content-box-div">Content Boxes</li>
        </ul>
        
        <div id="hook-box-div" class="tl-tab">
            <p>Use these boxes to insert text/html content to the defined Wordpress or Custom Theme Hooks.</p>
            <div id="hook-boxes">
                <?php
                    $hook_boxes = json_decode( get_option( 'txtins_hook_boxes' ) );
                    $hb_count = count($hook_boxes);

                    if ($hb_count > 0):
                        for ($i = 0; $i < $hb_count; $i++):
                ?>

                <div class="hook-box">
                    <div class="hb-upper-wrapper">
                        <div class="hb-options-div">
                            <span>Box Name</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[OPTIONAL] An arbitrary name for this box.">?</span><br>
                            <input type="text" name="name" class="name" value="<?php echo urldecode($hook_boxes[$i]->name); ?>" /><br><br>
                            <span>Hook</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[REQUIRED] The hook slug where the text/html content will be inserted.">?</span><br>
                            <input type="text" name="hook" class="hook" onkeydown="this.dataset.valid=false" onkeyup="TextInserts.validateHook(this)" data-valid="false" value="<?php echo $hook_boxes[$i]->hook; ?>" /><br><br>
                            <span>Show in</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[REQUIRED] Whether to show this box in posts, pages, both or only in the homepage.">?</span><br>
                            <select name="display" class="display">
                                <option value="1" <?php selected($hook_boxes[$i]->display, 1); ?> >posts &amp; pages</option>
                                <option value="2" <?php selected($hook_boxes[$i]->display, 2); ?> >posts only</option>
                                <option value="3" <?php selected($hook_boxes[$i]->display, 3); ?> >pages only</option>
                                <option value="4" <?php selected($hook_boxes[$i]->display, 4); ?> >homepage only</option>
                                <option value="5" <?php selected($hook_boxes[$i]->display, 5); ?> >everywhere</option>
                            </select><br><br>
                            <span>Filtering Method</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="Filter by including/excluding post/page IDs.">?</span><br>
                            <select name="filtering" class="filtering">
                                <option value="1" <?php selected($hook_boxes[$i]->filtering, 1); ?> >none</option>
                                <option value="2" <?php selected($hook_boxes[$i]->filtering, 2); ?> >exclude all except</option>
                                <option value="3" <?php selected($hook_boxes[$i]->filtering, 3); ?> >include all except</option>
                            </select><br><br>
                            <span>Filtered IDs</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[OPTIONAL] Comma-delimited list of post/page IDs.">?</span><br>
                            <input type="text" name="filtered-ids" class="filtered-ids" value="<?php echo urldecode($hook_boxes[$i]->filtered_list); ?>" /><br><br>
                            <span>Priority</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[REQUIRED] The lower the number, the higher the priority. Only change this if you know what action/filter priority is.">?</span><br>
                            <input type="text" name="priority" class="priority" value="<?php echo $hook_boxes[$i]->priority; ?>" />
                        </div>
                        <div class="hb-txt-div">
                            <span>Text / HTML</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[REQUIRED] The text/html content to be inserted.">?</span><br>
                            <textarea class="hb-txt-contentarea"><?php echo urldecode($hook_boxes[$i]->text); ?></textarea>
                        </div>
                        <div class="clear-fix"></div>
                    </div>
                    <div class="hb-lower-wrapper">
                        <input type="checkbox" name="enabled" class="enabled" value="1" <?php checked($hook_boxes[$i]->enabled); ?> /><span>Enable</span>
                        <span class="rem-parent">
                            <span class="remove-txt" onclick="TextInserts.displayRemoveConf(this)">Remove</span>
                        </span>
                    </div>
                </div>

                <?php endfor; endif; ?>
            </div>

            <div id="hb-control-box">
                <input type="button" onclick="TextInserts.addHookBox()" value="Add Box" />
            </div>
        </div>
		
		<div id="content-box-div" class="tl-tab">
            <p>Use these boxes to insert text/html content to the post/page content area.</p>
            <div id="content-boxes">
                <?php
                    $content_boxes = json_decode( get_option( 'txtins_content_boxes' ) );
                    $cb_count = count($content_boxes);

                    if ($cb_count > 0):
                        for ($i = 0; $i < $cb_count; $i++):

                        // change position options
                        $optStr = '';

                        if ($content_boxes[$i]->method == 1) {
                            $optStr = '<input type="number" name="position" class="position" min="1" value="'. $content_boxes[$i]->position .'" />';
                        }
                        else if ($content_boxes[$i]->method == 2) {
                            $optStr = '<input type="number" name="position" class="position" min="1" max="100" value="'. $content_boxes[$i]->position .'" />';
                        }
                        else if ($content_boxes[$i]->method == 3) {
                            $optStr = '<select name="position" class="position">
                                        <option value="1" '. selected($content_boxes[$i]->position, 1, false) .' >before the content</option>
                                        <option value="2" '. selected($content_boxes[$i]->position, 2, false) .' >after the content</option>
                                        <option value="3" '. selected($content_boxes[$i]->position, 3, false) .' >before the first paragraph</option>
                                        <option value="4" '. selected($content_boxes[$i]->position, 4, false) .' >after the first paragraph</option>
                                      </select>';
                        }
                ?>

                <div class="content-box">
                    <div class="cb-upper-wrapper">
                        <div class="cb-options-div">
                            <span>Box Name</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[OPTIONAL] An arbitrary name for this box.">?</span><br>
                            <input type="text" name="name" class="name" value="<?php echo urldecode($content_boxes[$i]->name); ?>" /><br><br>
                            <span>Show in</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[REQUIRED] Whether to show this box in posts, pages or both.">?</span><br>
                            <select name="display" class="display">
                                <option value="1" <?php selected($content_boxes[$i]->display, 1); ?> >posts &amp; pages</option>
                                <option value="2" <?php selected($content_boxes[$i]->display, 2); ?> >posts only</option>
                                <option value="3" <?php selected($content_boxes[$i]->display, 3); ?> >pages only</option>
                            </select><br><br>
                            <span>Filtering Method</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="Filter by including/excluding post/page IDs.">?</span><br>
                            <select name="filtering" class="filtering">
                                <option value="1" <?php selected($content_boxes[$i]->filtering, 1); ?> >none</option>
                                <option value="2" <?php selected($content_boxes[$i]->filtering, 2); ?> >exclude all except</option>
                                <option value="3" <?php selected($content_boxes[$i]->filtering, 3); ?> >include all except</option>
                            </select><br><br>
                            <span>Filtered IDs</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[OPTIONAL] Comma-delimited list of post/page IDs.">?</span><br>
                            <input type="text" name="filtered-ids" class="filtered-ids" value="<?php echo urldecode($content_boxes[$i]->filtered_list); ?>" /><br><br>
                            <span>Insertion Method</span> <span class="tooltip ins-tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="Text/html will be inserted after the nth paragraph.">?</span><br>
                            <select name="method" class="method" onchange="TextInserts.changeInsMethodTooltip(this)">
                                <option value="1" <?php selected($content_boxes[$i]->method, 1); ?> data-tooltip="Text/html will be inserted after the nth paragraph.">after nth paragraph</option>
                                <option value="2" <?php selected($content_boxes[$i]->method, 2); ?> data-tooltip="Text/html will be inserted after % of total paragraphs. <br><br>Example, if there are 6 paragraphs and 50 is supplied in the 'Insertion Position' field, text/html will be inserted after 6 * 0.5 paragraphs, which is after the 3rd paragraph.">after % of total paragraphs</option>
                                <option value="3" <?php selected($content_boxes[$i]->method, 3); ?> data-tooltip="Text/html will be inserted at {position}. Where {position} can be:<br><br>  <ul><li>before the content</li><li>after the content</li><li>before first paragraph</li><li>after the last paragraph</li></ul>">at position</option>
                            </select><br><br>
                            <span>Insertion Position</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="Where the text/html will be inserted into the content.">?</span><br>
                            <span class="position-wrap">
                                <?php echo $optStr; ?>
                            </span><br><br>
                            <span>Priority</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[REQUIRED] The lower the number, the higher the priority. Only change this if you know what action/filter priority is.">?</span><br>
                            <input type="text" name="priority" class="priority" value="<?php echo str_replace('&dbquot;', '"', $content_boxes[$i]->priority); ?>" />
                        </div>
                        <div class="cb-txt-div">
                            <span>Text / HTML</span> <span class="tooltip" tabindex="100" onfocus="TextInserts.displayTooltip(this)" onblur="TextInserts.removeTooltip(this)" data-tooltip="[REQUIRED] The text/html content to be inserted.">?</span><br>
                            <textarea class="cb-txt-contentarea"><?php echo urldecode($content_boxes[$i]->text); ?></textarea>
                        </div>
                        <div class="clear-fix"></div>
                    </div>
                    <div class="cb-lower-wrapper">
                        <input type="checkbox" name="enabled" class="enabled" value="1" <?php checked($content_boxes[$i]->enabled); ?> /><span>Enable</span>
                        <span class="rem-parent">
                            <span class="remove-txt" onclick="TextInserts.displayRemoveConf(this)">Remove</span>
                        </span>
                    </div>
                </div>

                <?php endfor; endif; ?>
            </div>

            <div id="cb-control-box">
                <input type="button" onclick="TextInserts.addContentBox()" value="Add Box" />
            </div>
        </div>
		<p><input type="button" class="button button-primary" onclick="TextInserts.tiSaveChanges()" value="Save Changes" /></p>
	</form>

</div>
