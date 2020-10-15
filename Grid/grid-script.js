var lastClicked;
var quadrantHeight = 10;
var quadrantWidth = 10;

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
    element.className = 'clicked';
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