// finhub key: bs1srb7rh5r9p5hv81q0



// API functions
function ajax(endptParam, typeParam) {
    //AJAX call with JS
    let httpRequest = new XMLHttpRequest();
    httpRequest.open("GET", endptParam );
    httpRequest.send();
    //handle server response event:
    httpRequest.onreadystatechange = function() {
        //this code will run on a response from server
        //request is ready on state 4
        console.log(httpRequest.readyState);
        if( httpRequest.readyState == 4){
            //http code 200 means success
            if(httpRequest.status == 200){
                displayResults(httpRequest.responseText, typeParam);
            }
            else{
                //display error message if something went wrong
                alert("AJAX error");
            }
        }	
    }
}


//function to display results from API response in this page
function displayResults(responseParam, type){


    //convert this JSON string into JS objects
    //in order to access individual info from search results
    let output = JSON.parse(responseParam);
    if(type == 0){
        console.log(output["name"]);
        document.querySelector("#name").innerHTML = "Name: " + output["name"];
    }
    else if(type == 1){
        document.querySelector("#price").innerHTML = "Current value: $" + output['c'];
        let dif = output["c"] - output["o"];
        dif = dif.toFixed(2);
        document.querySelector("#trend").innerHTML = "Trend: " + dif;
        if(dif > 0){
            document.querySelector("#trend").style.color = "green";
        }
        else if(dif < 0){
            document.querySelector("#trend").style.color = "red";
        }
        else{
            document.querySelector("#trend").style.color = "grey";
        }
    }
    else if(type == 2){
        document.querySelector("#source").innerHTML = 'News from source "' + output[1]["source"] + '":';
        document.querySelector("#results_display h4").innerHTML = output[1]["headline"];
        document.querySelector("#news").innerHTML = output[1]["summary"];
        document.querySelector("#more").innerHTML = "More at " + output[1]["url"];
        document.querySelector("#more").href = output[1]["url"];
    }
}

// API CALLS

//ajax("https://finnhub.io/api/v1/stock/symbol?exchange=US&token=bs1srb7rh5r9p5hv81q0");
//ajax("https://finnhub.io/api/v1/quote?symbol=AAPL&token=bs1srb7rh5r9p5hv81q0");

/*
document.querySelector("#nav .btn").onmouseenter = function() {
    this.style.backgroundColor = "mediumseagreen";
    this.style.color = "black";
};
document.querySelector("#nav .btn").onmouseleave = function() {
    this.style.backgroundColor = "black";
    this.style.color = "mediumseagreen";
};
*/