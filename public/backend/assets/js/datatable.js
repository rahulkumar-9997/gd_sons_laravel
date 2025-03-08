var ULTRA_SETTINGS = window.ULTRA_SETTINGS || {};

jQuery(function($) {
    'use strict';
    
    /*--------------------------------
         DataTables
     --------------------------------*/
     ULTRA_SETTINGS.dataTablesInit = function() {

        if ($.isFunction($.fn.dataTable)) {

            /*--- start ---*/

            $("#example-21").dataTable({
                responsive: false,
                paging: false,
                columnDefs: [
                    { orderable: false, targets: [0, 1, 3, 8] }
                 ],
                aLengthMenu: [
                    [20, 40, 60, 100, -1],
                    [20, 40, 60, 100, "All"]
                ]
            });
            $("#example-1").dataTable({
                responsive: true,
                aLengthMenu: [
                    [20, 40, 60, 100, -1],
                    [20, 40, 60, 100, "All"]
                ]
            });
            

            /*--- end ---*/

            /*--- start ---*/

            $('#example-4').dataTable();

            /*--- end ---*/

            // Rest of your code goes here...

        }
    };

});

// Ensure this is called within the same scope as where ULTRA_SETTINGS is defined
$(document).ready(function() {
    ULTRA_SETTINGS.dataTablesInit();
});
