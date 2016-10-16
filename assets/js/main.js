/******************************************************************************
 * Copyright (c) 2016 Project-manager XAMPP / Web. All rights reserved.             *
 * Author      : Breith Barbot                                                *
 * Created on  : 16/10/16 16:31                                               *
 * File name   : main.js                                                      *
 * Description :                                                              *
 ******************************************************************************/

$(document).ready(function () {
    // Search projects
    $('#search').on('keyup', function () {
        var val = $(this).val().toLowerCase(), i = 0;
        $('.bb-project-manager').each(function () {
            if ($(this).data('title').indexOf(val) !== -1) {
                $(this).parent().show();
                i++;
            } else {
                $(this).parent().hide();
            }
        });

        // Test nb project
        var nbProjet = (i > 1) ? 'Il y a <strong>' + i + '</strong> projets' : 'Il y a <strong>' + i + '</strong> projet';
        $('#nbProjet').html(nbProjet);
    });

    // Resize window
    $(window).resize(function () {
        showHide_link();
    });

});

/**
 * Detect a 'touch screen' device
 * Source : http://stackoverflow.com/a/4819886/2146064
 *
 * @returns {boolean|*}
 */
function is_touch_device() {
    return 'ontouchstart' in window        // works on most browsers
        || navigator.maxTouchPoints;       // works on IE10/11 and Surface
}

/**
 * Change value attribute 'href'
 */
function showHide_link() {

    // If 'touch screen' device
    if (is_touch_device()) {
        $('.bb-project-manager-content-img a').each(function () {
            $(this).attr('href', 'javascript:void(0);');
        });
    } else {
        $('.bb-project-manager-content-img a').each(function () {
            $(this).attr('href', $(this).data('href'));
        });
    }

}