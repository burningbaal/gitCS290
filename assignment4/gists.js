//http://stackoverflow.com/questions/14949210/dynamically-update-a-table-using-javascript

    var request = new XMLHttpRequest();
    request.onload = requestResponse;
    request.open('get', 'https://api.github.com/gists', true);
    request.send();

    var allGists = "uh-oh, No Gists!";
function insertRow(tableName, rowNum, data, url)
{    //data should be array of strings (each column of the table)
    //alert("in");
    var table = document.getElementById(tableName);
    var cells = new Array(data.length);
    //alert("made Cell array");
    var row = table.insertRow(rowNum);
    //alert("in insertRow(), " + rowNum);
    for (var iter = 0; iter < cells.length; iter++)
    {
        //alert(data[iter]);
        cells[iter] = row.insertCell(iter);
        /*var a = document.createElement('a');
        var linkText = document.createTextNode(data[iter]);
        a.appendChild(linkText);
        a.title = data[iter];
        a.href = "url";*/
        cells[iter].innerHTML = '<a href="'+ url +'">' + data[iter] + '</a>';
    }
}

function getRadioVal(form, name) 
{
    //from http://www.dyn-web.com/tutorials/forms/radio/get-selected.php
    var val;
    // get list of radio buttons with specified name
    var radios = form.elements[name];
    
    // loop through list of radio buttons
    for (var i=0, len=radios.length; i<len; i++) {
        if ( radios[i].checked ) { // radio checked?
            val = radios[i].value; // if so, hold its value in val
            break; // and break out of for loop
        }
    }
    return val; // return value of checked radio or undefined if none checked
}

function requestResponse()
{
	var responseObj = JSON.parse(this.responseText);
    var iter, count;
    var outputText = "";
    var GistData;
    document.getElementById("GistsTable").deleteRow(1);
    for(iter in responseObj)
    {
        //console.log("in for loop, " + "iter: " + iter);
        if("" < responseObj[iter].updated_at)
        {
            //console.log("in if! " + "iter: " + iter);
            GistData = new Array(4);
            GistData[0] = String(responseObj[iter].updated_at);
            GistData[1] = String(responseObj[iter].description);
            GistData[2] = String(responseObj[iter].user);
            //console.log(GistData[0] + " " + GistData[1] +  " " + GistData[2]);
            for (var index in responseObj[iter].files)
            {
                //console.log("file: " + index);
                GistData[3] = String(responseObj[iter].files[index].language);
                var LangSelected = getRadioVal(document.getElementById('GistForm'),'lang');
                console.log(LangSelected);
                if(LangSelected == undefined || GistData[3] == langSelected)
                {
                    insertRow('GistsTable',document.getElementById("GistsTable").rows.length, GistData, responseObj[iter].url);
                    count++;
                }
            }
            
            insertRow('GistsTable',document.getElementById("GistsTable").rows.length, GistData, responseObj[iter].url);
        }
    }

	//
};
