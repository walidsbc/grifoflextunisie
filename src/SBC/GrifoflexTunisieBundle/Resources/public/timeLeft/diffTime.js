
function diffTime(start){

    var now = moment();


 if (now.diff(start, 'months') >= 2) {
           return "danger";
    }

    else if (now.diff(start, 'months') >= 1) {
		
        return "warning";
    }
   
    else {
        return "info";

    }

}
