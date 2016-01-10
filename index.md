---
layout: page
title: Mutual Buddies Documentation!
tagline: codex
category: [template,themes]
---
{% include JB/setup %}

Mutual buddies displays BuddyPress mutual friends of the logged in user & the user whose profile the user is looking at on the Profile page. 

Download [Mutual Buddies](https://wordpress.org/plugins/mutual-buddies/)


## Template Structure + Overriding Templates via a Theme

Mutual Buddies provides a templating system. This means that every element displayed on a Mutual Buddies page can be overridden.

This system’s advantage is that you can modify the display of an element without editing Mutual Buddies core files (which is absolutely NOT recommended, if you do so, all your modifications will be lost at the next Mutual Buddies update, so just don’t do it). All templates are located in a `mutual-buddies/templates` folder. As explained in our documentation, all you have to do is to create a `mutual-buddies` folder within your theme’s directory, and in this folder duplicate the files you’d like to override. Please note that we strongly recommend using a child theme in order not to lose any modifications during your theme update.


* The **friends-loop-dialog.php** file output a list of mutual fiends and friends that are registered on your site in dialog.
    
* The **friends-loop.php** file output a list of mutual fiends and friends that are registered on your site.


#### Example:

Let’s say you would like to add a new class to mutual friends dialog in order to apply custom CSS code to the popup. You would need to duplicate the `mutual-buddies/templates/friends-loop-dialog.php` file in the following folder wp-content/themes/your-theme-folder `/mutual-buddies/` and change the following code  `<div class="popup-scroll">` to `<div class="popup-scroll my-custom-css-class">`.

## Hooks: Action and Filter Reference

Mutual Buddies easily expandable. It has many hooks that can be used for nearly everything, and that’s what make Mutual Buddies so good. Here is a list of snippets I wrote during the past month; all these snippets must be pasted in the `functions.php` file within your theme folder:

### Remove frind/mutual-friends count from buddypress memeber loop

        /**
         * bmf_member_loop_show_total_count is a 1.8+ hook
         */
        add_filter( 'bmf_member_loop_show_total_count', '__return_false' );

### Remove mutual friends count from buddypress memeber loop


        /**
         * bmf_show_mutual_friend_count is a 1.3+ hook
         */
        add_filter( 'bmf_show_mutual_friend_count', '__return_false' ); 

### Remove friends count from buddypress memeber loop

        /**
         * bmf_show_friend_count is a 1.3+ hook
         */
        add_filter( 'bmf_show_friend_count', '__return_false' );

       


