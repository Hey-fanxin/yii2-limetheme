/* ========================================================================
 * Bootstrap: .js v3.3.7
 * http://getbootstrap.com/javascript/#modal
 * ========================================================================
 * Copyright 2011-2016 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */

+ function ($) {
    'use strict';

    // MODAL CLASS DEFINITION ======================
    $(".open-modal").click(function () {
        console.log('modal')
        $("#myModal").modal("show");
    });

}(jQuery)