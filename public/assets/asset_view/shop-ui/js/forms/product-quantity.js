function subtractQty(){
    if(document.getElementById("qty").value <= document.getElementById("min_order_qty").value){
        return;
    }else{
        if(document.getElementById("qty").value - 1 < 0)
            return;
        else
            document.getElementById("qty").value--;
    }

}

function subtractQty1() {
    if(document.getElementById("qty1").value - 1 < 0)
        return;
    else
        document.getElementById("qty1").value--;
}

function subtractQty2() {
    if(document.getElementById("qty2").value - 1 < 0)
        return;
    else
        document.getElementById("qty2").value--;
}

function subtractQty3() {
    if(document.getElementById("qty3").value - 1 < 0)
        return;
    else
        document.getElementById("qty3").value--;
}

function subtractQty4() {
    if(document.getElementById("qty4").value - 1 < 0)
        return;
    else
        document.getElementById("qty4").value--;
}

function SubPlusQty(){
    var value = document.getElementById("qty").value;
    var changeValue = (value*1+1*1);
    document.getElementById("qty").value = (changeValue);
}