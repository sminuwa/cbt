(function($) {
    $.fn.calculator = function() {
        return this.each(function() {
            var input = "";
            // console.log();
            var $calculatorPopup = $('#calculatorPopup').length?$('#calculatorPopup'):$('<div id="calculatorPopup">');
            var $closeButton = $('<button class="closeButton button-14">X</button>');
            var $calculatorContent = $('<div id="calculatorButtons">');
            var $display = $('<div class="display">');
            var $displaySmall = $('<input type="text" readonly class="displaySmall">');
            var $displayBig = $('<input type="text" readonly class="displayBig">');
            var $result = $('<p>');
            var eqlPrs  = 0;
            $calculatorPopup.html('');
            // Display and result elements
            $displaySmall.appendTo($display);
            $displayBig.appendTo($display);
            $display.appendTo($calculatorPopup);

            // Calculator content
            // $('<h2>Simple Calculator</h2>').appendTo($calculatorPopup);

            // Append calculator buttons as a table
            var buttons = ['7', '8', '9', '/', '4', '5', '6', '*', '1', '2', '3', '-', '=', '0', '.', '+'];
            var $table = $('<table class="table btnTable" border="1">');
            for (var i = 0; i < buttons.length; i++) {
                if (i % 4 === 0) {
                    var $row = $('<tr>');
                    $row.appendTo($table);
                }
                var $cell = $('<td>');
                var $button = $('<button class="calculatorButton button-14">' + buttons[i] + '</button>');
                $button.appendTo($cell);
                $cell.appendTo($row);
            }
            $table.appendTo($calculatorContent);
            $calculatorContent.appendTo($calculatorPopup);

            console.log($calculatorContent.html())
            $('<br>').appendTo($calculatorPopup);
            $result.appendTo($calculatorPopup);

            // Close button
            $closeButton.click(function() {
                $calculatorPopup.hide();
                $("#calculatorPopup").hide();
            });
            $closeButton.appendTo($calculatorPopup);

            // Append calculator popup to body
            $calculatorPopup.appendTo($('body'));

            // Functions for calculator buttons
            var appendValue = function(value) {
                // $displayBig.val( += value;
                $displayBig.val($displayBig.val()+value);
            };

            var isNumeric = function isNumeric(value) {
                return !isNaN(parseFloat(value)) && isFinite(value);
            }

            var calculate = function() {
                try {
                    var result = eval($displaySmall.val());
                    $displayBig.val( result);
                    $displaySmall.val( '');
                    eqlPrs = 1;
                } catch (error) {
                    $result.text('Invalid expression');
                }
            };

            // Event handler for calculator buttons
            $(this).on('click', '.calculatorButton', function() {
                var value = $(this).text();
                if (value === '=') {
                    $displaySmall.val($displaySmall.val()+$displayBig.val());
                    calculate();
                } else if (value === 'C') {
                    input = "";
                    $displaySmall.val("");
                    $displayBig.val("");
                    $result.text("");
                    eqlPrs=0;
                } else {

                    if(isNumeric(value)){
                        if(eqlPrs){
                            $displayBig.val( '');
                        }
                        appendValue(value);
                    }else{
                        appendValue(value);
                        $displaySmall.val($displaySmall.val()+$displayBig.val());
                        $displayBig.val("")
                    }
                    eqlPrs=0;

                }
            });
        });
    };
})(jQuery);
