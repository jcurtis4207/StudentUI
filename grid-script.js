window.onload=function(){
    var quadrantHeight = 10;
    var quadrantWidth = 10;
    var lastClicked;
    // define grid  
    function clickableGrid(rows, columns, callback) {
        var i = 0;
        var grid = document.createElement('table');
        grid.className = 'grid';
        for (var r = 0; r < rows; ++r) {
            var tr = grid.appendChild(document.createElement('tr'));
            for (var c = 0; c < columns; ++c) {
                var cell = tr.appendChild(document.createElement('td'));
                cell.innerHTML = "";
                // add click listener
                cell.addEventListener('click', (function(element, r, c) {
                    return function() {
                        callback(element, r, c);
                    }
                })(cell, r, c), false);
            }
        }
        return grid;
    }
    // create grid
    var grid = clickableGrid(quadrantHeight * 2, quadrantWidth * 2, function(element, row, column) {
        // print selected cell to console and send to grid.php
        // configured for positive/negative values with no 0
        var outputX = column - quadrantWidth;
        var outputY = quadrantHeight - row;
        if (outputX >= 0) {
            outputX++;
        }
        if (outputY <= 0) {
            outputY--;
        }
        console.log("Selected (", outputX, ",", outputY, ")");
        document.getElementById("x_value").value = outputX;
        document.getElementById("y_value").value = outputY;
        // use css to add colored circle to last clicked cell
        element.className = 'selected';
        if (lastClicked) {
            lastClicked.className = '';
        }
        lastClicked = element;
        // enable submit button
        document.getElementById("submit-button").disabled = false;
    });
    // add grid to html body
    let domTable = document.querySelector('#dom-table')
    domTable.appendChild(grid);
    // add listeners to buttons
    var submit_button = document.getElementById('submit-button');
    var skip_button = document.getElementById('skip-button');
    submit_button.addEventListener("click", submitRating);
    skip_button.addEventListener("click", skipRating);
}

function submitRating(){
    //Confirm dialogue before user submits rating
    var confirmation = confirm("Are you sure you want to submit this rating?\nYou cannot return to rate this question again.");
    if(confirmation == true){
        document.getElementById('output_form').submit();
    }
}
function skipRating(){
    var confirmation = confirm("Are you sure you want to skip this question?\nYou cannot return to rate this question again.");
    if(confirmation == true){
        // set x and y to 0 and submit form
        document.getElementById('x_value').value = 0;
        document.getElementById('y_value').value = 0;
        document.getElementById('output_form').submit();
    }
}