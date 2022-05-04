
if (document.readyState == 'loading') {
    document.addEventListener('DOMContentLoaded', ready)
} else {
    ready()
}



/*----validation login screen --*/

window.onload = function(){

    (function ($) {
        "use strict";


        /*==================================================================
        [ Focus input ]*/
        $('.input100').each(function(){
            $(this).on('blur', function(){
                if($(this).val().trim() != "") {
                    $(this).addClass('has-val');
                }
                else {
                    $(this).removeClass('has-val');
                }
            })    
        })
    
    
        /*==================================================================
        [ Validate ]*/
        var input = $('.validate-input .input100');

        $('.validate-form').on('submit',function(){
            var check = true;

            for(var i=0; i<input.length; i++) {
                if(validate(input[i]) == false){
                    showValidate(input[i]);
                    check=false;
                }
            }

            return check;
        });


        $('.validate-form .input100').each(function(){
            $(this).focus(function(){
            hideValidate(this);
            });
        });

        function validate (input) {
            if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
                if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                    return false;
                }
            }
            else {
                if($(input).val().trim() == ''){
                    return false;
                }
            }
        }

        function showValidate(input) {
            var thisAlert = $(input).parent();

            $(thisAlert).addClass('alert-validate');
        }

        function hideValidate(input) {
            var thisAlert = $(input).parent();

            $(thisAlert).removeClass('alert-validate');
        }
        
        /*==================================================================
        [ Show pass ]*/
        var showPass = 0;
        $('.btn-show-pass').on('click', function(){
            if(showPass == 0) {
                $(this).next('input').attr('type','text');
                $(this).find('i').removeClass('zmdi-eye');
                $(this).find('i').addClass('zmdi-eye-off');
                showPass = 1;
            }
            else {
                $(this).next('input').attr('type','password');
                $(this).find('i').addClass('zmdi-eye');
                $(this).find('i').removeClass('zmdi-eye-off');
                showPass = 0;
            }
            
        });


    })(jQuery);
}


/*----end validation login screen --*/


/*------Searchbar------*/

function searchbar() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("Input");
    filter = input.value.toUpperCase();
    listOfItems = document.getElementById("listOfItems");
    item = listOfItems.getElementsByClassName("item");
    for (i = 0; i < item.length; i++) {
        itemName = item[i].getElementsByClassName("itemName")[0];
        itemEAN = item[i].getElementsByClassName("EAN13")[0];
        txtValue = itemName.textContent || itemName.innerText;
        txtValue2 = itemEAN.textContent || itemEAN.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            item[i].style.display = "";
        } 
        
        else if(txtValue2.toUpperCase().indexOf(filter) > -1)
        {
            item[i].style.display = "";
        }
        else {
            item[i].style.display = "none";
        }
    }
}

/*------End Searchbar------*/

/*--------Checkout----------*/

function ready() {
    var removeCartItemButtons = document.getElementsByClassName('btn-danger')
    for (var i = 0; i < removeCartItemButtons.length; i++) {
        var button = removeCartItemButtons[i]
        button.addEventListener('click', removeCartItem)
    }

    var quantityInputs = document.getElementsByClassName('cart-quantity-input')
    for (var i = 0; i < quantityInputs.length; i++) {
        var input = quantityInputs[i]
        input.addEventListener('change', quantityChanged)
    }

    var addToCartButtons = document.getElementsByClassName('item')
    for (var i = 0; i < addToCartButtons.length; i++) {
        var button = addToCartButtons[i]
        button.addEventListener('click', addToCartClicked)
    }


    //jamie is trying stuff, i need help -----------------------------------------------------
    /*
        if the selected order is not "new order"{
            const jsonOrder = ;
            addItemToCart(title, price, pid)
        }
    */
    // var orderID = "<%= $_SESSION['orderID'] %>";
    // if(orderID != 'New Order'){
    //     var file = "";
    //     file.open("GET", "ordersFile/order${orderID}.json", false);
    //     file.send(null);
    //     var fileContents = JSON.parse(file.responseText);
    //     window.alert(fileContents.result[0]);
    // }
    //jamie is done trying stuff, i still need help -----------------------------------------------------


    //document.getElementsByClassName('btn-purchase')[0].addEventListener('click', purchaseClicked)
}
/*
function purchaseClicked() {
    alert('Thank you for your purchase')
    var cartItems = document.getElementsByClassName('cart-items')[0]
    while (cartItems.hasChildNodes()) {
        cartItems.removeChild(cartItems.firstChild)
    }
    updateCartTotal()
}
*/
function removeCartItem(event) {
    var buttonClicked = event.target
    buttonClicked.parentElement.parentElement.remove()
    updateCartTotal()
}

function quantityChanged(event) {
    var input = event.target
    if (isNaN(input.value) || input.value <= 0) {
        input.value = 1
    }
    updateCartTotal()
}

function addToCartClicked(event) {
    var button = event.target
    var shopItem = button.parentElement.parentElement
    var title = shopItem.getElementsByClassName('itemName')[0].innerText
    var price = shopItem.getElementsByClassName('itemPrice')[0].innerText
    var pid = shopItem.getElementsByClassName('pid')[0].innerText
    
    
    

        addItemToCart(title, price, pid)
        updateCartTotal()
    
}


function addItemToCart(title, price, pid) {
    var cartRow = document.createElement('div')
    cartRow.classList.add('cart-row')
    debugger;
    var cartItems = document.getElementsByClassName('cart-items')[0]
    var cartItemNames = cartItems.getElementsByClassName('cart-quantity-input')
    
    for (var i = 0; i < cartItemNames.length; i++) {
        if (cartItemNames[i].getAttribute('fname') == title) {
            let x = cartItemNames[i].value
            const y = x++
            cartItemNames[i].setAttribute("value",x)
            return
        }
    }


    $(function numberlist(){
        var $select = $(".1-100");
        for (i=1;i<=100;i++){
            $select.append($('<option></option>').val(i).html(i))
        }
    })

   

    var cartRowContents = `
        <div class="cart-item cart-column">
            <span class="cart-item-title">
            <input hidden name="itemTitle[]" value="${title}">
            ${title}</span>
            <span class="cart-price cart-column">
            <input hidden name="itemPrice[]" value="${price}">
            £${price}</span>
            <input hidden class="pid" name="pid[]" value="${pid}">
            <img src="images/icons/trash.svg" alt="deleteButton" class="btn-danger"/>
            <input class="cart-quantity-input" name="quantity[]" type="number" fname="${title}" value="1">            
        </div>
        
       `
    cartRow.innerHTML = cartRowContents
    cartItems.append(cartRow)
    cartRow.getElementsByClassName('btn-danger')[0].addEventListener('click', removeCartItem)
    cartRow.getElementsByClassName('cart-quantity-input')[0].addEventListener('change', quantityChanged)
}

function updateCartTotal() {
    var cartItemContainer = document.getElementsByClassName('cart-items')[0]
    var cartRows = cartItemContainer.getElementsByClassName('cart-row')
    var total = 0
    for (var i = 0; i < cartRows.length; i++) {
        var cartRow = cartRows[i]
        var priceElement = cartRow.getElementsByClassName('cart-price')[0]
        var quantityElement = cartRow.getElementsByClassName('cart-quantity-input')[0]
        var price = parseFloat(priceElement.innerText.replace('£', ''))
        var quantity = quantityElement.value
        total = total + (price * quantity)
    }
    total = Math.round(total * 100) / 100
    document.getElementsByClassName('cart-total-price')[0].innerText = "£" + total
    document.getElementById('total').setAttribute('value', total)
    document.getElementById('submit').removeAttribute('disabled')
}
/*
//Jamie 01/05/2022
$(document).ready(function() {
    $("input[name='payment']").change(function() {
        if ($(this).val() == "CASH") {
            $("#cashBox").show();
        } else {
            $("#cashBox").hide();
        }
    });
});

function cashSet(){
    if(document.getElementsByName('payment') == "CASH")
    {
        document.getElementById('cashBox').setAttribute('required', true);
    }
    else
    {
        document.getElementById('cashBox').setAttribute('required', false);
    }
}

/*--------End checkout----------*/
