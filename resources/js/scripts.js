function ordernaTAB(n, tab = 'tab') {
    ShowSpinModal(tab);
    setTimeout(function () {
        var myArray = [];    
        rows = document.getElementById(tab).getElementsByTagName("TR");
        lines = rows[0].getElementsByTagName("TH");
        for (i = 0; i < (lines.length - 1); i++) {
            if (String(n) != String(i)){                       
                tdSort = rows[0].getElementsByTagName("TH")[i]; 
                $('i', tdSort).removeClass("fa-sort-up");
                $('i', tdSort).removeClass("fa-sort-down");
                $('i', tdSort).addClass("fa-sort");
            }
        }

        tdSort = rows[0].getElementsByTagName("TH")[n];

        var order = 'asc';
        if($('i', tdSort).hasClass("fa-sort")){
            $('i', tdSort).removeClass("fa-sort");
            $('i', tdSort).addClass("fa-sort-up");
            
        } else if ($('i', tdSort).hasClass("fa-sort-down")){
            $('i', tdSort).removeClass("fa-sort-down");
            $('i', tdSort).addClass("fa-sort-up");

        } else if ($('i', tdSort).hasClass("fa-sort-up")){
            $('i', tdSort).removeClass("fa-sort-up");
            $('i', tdSort).addClass("fa-sort-down");
            order = 'desc';
        }
        var QtdeRows = rows.length-2;

        for (i = 1; i < (rows.length - 1); i++) {
            x = rows[i].getElementsByTagName("TD")[n];
            var xAux = x.innerHTML;
            xAux = DateToInt(xAux);

            myArray.push(((xAux).replace(".", "").replace(",", "."))+idx+i);
        }  

        var sortedArray = quick_Sort(myArray, order);

        var TRtotal = rows[rows.length-1];
        for(valor in sortedArray){
            let TRNova = document.createElement("tr");
            var value = sortedArray[valor];
            value = value.substring(value.indexOf(idx));        
            value = parseInt(value.replace(idx, ""));

            TRNova.innerHTML = rows[value].innerHTML;
            TRNova.id = rows[value].id;
            TRNova.name = rows[value].name;
            rows[1].parentNode.appendChild(TRNova);
        }
        rows[1].parentNode.appendChild(TRtotal);

        for (i = QtdeRows; i > 0; i--) {
            rows[i].parentNode.removeChild(rows[i]);
        }
        
        HideSpinModal();
    }, 50);
}

function quick_Sort(origArray, order) {
	if (origArray.length <= 1) { 
		return origArray;
	} else {

		var left = [];
		var right = [];
		var newArray = [];
        var pivot = origArray.pop();
        var length = origArray.length;
        var qsLeft = true;

		for (var i = 0; i < length; i++) {
            var x = origArray[i].substring(0, origArray[i].indexOf(idx));
            var y = pivot.substring(0, pivot.indexOf(idx));          

            x = (isNaN(x)? origArray[i]: parseFloat(x));
            y = (isNaN(y)? pivot: parseFloat(y));            

            qsLeft = ((order == 'asc')? (x <= y): (x >= y));
            ((qsLeft)? left.push(origArray[i]): right.push(origArray[i]));
		}

		return newArray.concat(quick_Sort(left, order), pivot, quick_Sort(right, order));
	}
}

function removerLinha(botao) {
    const linha = botao.closest('tr');
    linha.remove();
}