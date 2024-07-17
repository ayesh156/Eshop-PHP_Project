function changeView() {

    var signUpBox = document.getElementById("signUpBox");
    var signInBox = document.getElementById("signInBox");

    signUpBox.classList.toggle("d-none");
    signInBox.classList.toggle("d-none");
}

function signUp() {
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var mobile = document.getElementById("mobile");
    var gender = document.getElementById("gender");

    var form = new FormData();
    form.append("f", fname.value);
    form.append("l", lname.value);
    form.append("e", email.value);
    form.append("p", password.value);
    form.append("m", mobile.value);
    form.append("g", gender.value);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Success") {
                document.getElementById("msg").className = "bi bi-check2-circle fs-5";
                document.getElementById("msg").innerHTML = " " + text;
                document.getElementById("msgdiv").className = "opacity-100";
                document.getElementById("alertdiv").className = "alert alert-success";
            } else {
                document.getElementById("msg").innerHTML = " " + text;
                document.getElementById("msg").className = "bi bi-x-octagon-fill fs-5";
                document.getElementById("msgdiv").className = "opacity-100";
                document.getElementById("alertdiv").className = "alert alert-danger";

            }
        }
    }

    request.open("POST", "signUpProcess.php", true);
    request.send(form);
}

function signIn() {

    var email = document.getElementById("email2");
    var password = document.getElementById("password2");
    var rememberme = document.getElementById("rememberme");

    var form = new FormData();
    form.append("e", email.value);
    form.append("p", password.value);
    form.append("r", rememberme.checked);

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            var text = request.responseText;
            if (text == "Success") {
                document.getElementById("msg2").className = "bi bi-check2-circle fs-5";
                document.getElementById("msg2").innerHTML = " " + text;
                document.getElementById("msgdiv2").className = "opacity-100";
                document.getElementById("alertdiv2").className = "alert alert-success";
                window.location = "home.php";
            } else {
                document.getElementById("msg2").innerHTML = " " + text;
                document.getElementById("msg2").className = "bi bi-x-octagon-fill fs-5";
                document.getElementById("msgdiv2").className = "opacity-100";
                document.getElementById("alertdiv2").className = "alert alert-danger";

            }
        }
    }

    request.open("POST", "signInProcess.php", true);
    request.send(form);

}

var bm;
function forgotPassword() {

    var email = document.getElementById("email2");

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "Success") {
                document.getElementById("msg2").className = "bi bi-check2-circle fs-5";
                document.getElementById("msg2").innerHTML = " Verification code has send to your Email. Please check your inbox";
                document.getElementById("msgdiv2").className = "opacity-100";
                document.getElementById("alertdiv2").className = "alert alert-success";
                setTimeout(function () {
                    var m = document.getElementById("forgotPasswordModal");
                    bm = new bootstrap.Modal(m);
                    bm.show();
                }, 1000);
            } else {
                document.getElementById("msg2").innerHTML = " " + t;
                document.getElementById("msg2").className = "bi bi-x-octagon-fill fs-5";
                document.getElementById("msgdiv2").className = "opacity-100";
                document.getElementById("alertdiv2").className = "alert alert-danger";

            }
        }
    }

    r.open("GET", "forgotPasswordProcess.php?e=" + email.value, true);
    r.send();

}

function showPassword1() {

    var i = document.getElementById("npi");
    var eye = document.getElementById("e1");

    if (i.type == "password") {
        i.type = "text";
        eye.className = "bi bi-eye-fill";
    } else {
        i.type = "password";
        eye.className = "bi bi-eye-slash-fill";
    }
}

function showPassword2() {

    var i = document.getElementById("rnp");
    var eye = document.getElementById("e2");

    if (i.type == "password") {
        i.type = "text";
        eye.className = "bi bi-eye-fill";
    } else {
        i.type = "password";
        eye.className = "bi bi-eye-slash-fill";
    }
}

function resetpw() {

    var email = document.getElementById("email2");
    var np = document.getElementById("npi");
    var rnp = document.getElementById("rnp");
    var vcode = document.getElementById("vc");

    var form = new FormData();
    form.append("e", email.value);
    form.append("n", np.value);
    form.append("r", rnp.value);
    form.append("v", vcode.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "Success") {
                bm.hide();
                document.getElementById("msg2").className = "bi bi-check2-circle fs-5";
                document.getElementById("msg2").innerHTML = " Your password has been reset successfully";
                document.getElementById("msgdiv2").className = "opacity-100";
                document.getElementById("alertdiv2").className = "alert alert-success";
            } else {
                alert(t);
            }


        }
    }

    r.open("POST", "resetPassword.php", true);
    r.send(form);

}

function signout() {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {

                window.location.reload();

            } else {
                alert(t);
            }
        }
    }

    r.open("GET", "signoutProcess.php", true)
    r.send();

}

function changeImage() {
    var view = document.getElementById("viewImg");
    var file = document.getElementById("profileimg");

    file.onchange = function () {
        var file1 = this.files[0];
        var url = window.URL.createObjectURL(file1);
        view.src = url;
    }
}

function updateProfile() {
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var mobile = document.getElementById("mobile");
    var line1 = document.getElementById("line1");
    var line2 = document.getElementById("line2");
    var province = document.getElementById("province");
    var district = document.getElementById("district");
    var city = document.getElementById("city");
    var pcode = document.getElementById("pcode");
    var image = document.getElementById("profileimg");

    var f = new FormData();
    f.append("fn", fname.value);
    f.append("ln", lname.value);
    f.append("m", mobile.value);
    f.append("l1", line1.value);
    f.append("l2", line2.value);
    f.append("p", province.value);
    f.append("d", district.value);
    f.append("c", city.value);
    f.append("pc", pcode.value);

    if (image.files.length == 0) {
        var confirmation = confirm("Are you sure You don't want to update Profile Image?");

        if (confirmation) {
            alert("You have not selected any image");
        }
    } else {
        f.append("image", image.files[0]);
    }

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            alert(t);
        }
    }

    r.open("POST", "updateProfileProcess.php", true);
    r.send(f);

}

function loadDistrict() {
    var province = document.getElementById("province");

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("district").innerHTML = t;
        }
    }

    r.open("GET", "loadDistrict.php?p=" + province.value, true);
    r.send();
}

function loadCity() {
    var district = document.getElementById("district");

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("city").innerHTML = t;
        }
    }

    r.open("GET", "loadCity.php?d=" + district.value, true);
    r.send();
}

function changeProductImage() {
    var image = document.getElementById("imageuploader");

    image.onchange = function () {

        var file_count = image.files.length;

        if (file_count <= 3) {

            for (var x = 0; x < file_count; x++) {
                var file = this.files[x];
                var url = window.URL.createObjectURL(file);

                document.getElementById("i" + x).src = url;

            }

        } else {
            alert("Please select 3 or less than 3 images.");
        }

    }
}

function addProduct() {
    var category = document.getElementById("category");
    var brand = document.getElementById("brand");
    var model = document.getElementById("model");
    var title = document.getElementById("title");

    var condition = 0;
    if (document.getElementById("b").checked) {
        condition = 1;
    } else if (document.getElementById("u").checked) {
        condition = 2;
    }

    var colour = document.getElementById("clr");
    var colour_input = document.getElementById("clr_in");
    var qty = document.getElementById("qty");
    var cost = document.getElementById("cost");
    var dwc = document.getElementById("dwc");
    var doc = document.getElementById("doc");
    var desc = document.getElementById("desc");
    var image = document.getElementById("imageuploader");

    var f = new FormData();

    f.append("ca", category.value);
    f.append("b", brand.value);
    f.append("m", model.value);
    f.append("t", title.value);
    f.append("con", condition);
    f.append("col", colour.value);
    f.append("col_in", colour_input.value);
    f.append("qty", qty.value);
    f.append("cost", cost.value);
    f.append("dwc", dwc.value);
    f.append("doc", doc.value);
    f.append("desc", desc.value);


    var file_count = image.files.length;

    for (var x = 0; x < file_count; x++) {
        f.append("image" + x, image.files[x]);
    }

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "Product image saved successfully") {
                window.location.reload();
                alert("Product saved successfully");
            } else {
                alert(t);
            }
        }
    }

    r.open("POST", "addProductProcess.php", true);
    r.send(f);

}

function load_brand() {

    var category = document.getElementById("category");

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("brand").innerHTML = t;
        }
    }

    r.open("GET", "loadBrand.php?c=" + category.value, true);
    r.send();

}

function load_model() {

    var brand = document.getElementById("brand");

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("model").innerHTML = t;
        }
    }

    r.open("GET", "loadModel.php?b=" + brand.value, true);
    r.send();

}

function changeStatus(id) {

    var product_id = id;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "Deactivated") {
                alert("Product Deactivated");
                window.location.reload();
            } else if (t == "Activated") {
                alert("Product Activated");
                window.location.reload();
            } else {
                alert(t);
            }
        }
    }

    r.open("GET", "onchangeStatusProcess.php?p=" + product_id, true);
    r.send();

}

function sort1(x) {

    var search = document.getElementById("s");
    var time = "0";

    if (document.getElementById("n").checked) {
        time = "1";
    } else if (document.getElementById("o").checked) {
        time = "2";
    }

    var qty = "0";

    if (document.getElementById("h").checked) {
        qty = "1";
    } else if (document.getElementById("l").checked) {
        qty = "2";
    }

    var condition = "0";

    if (document.getElementById("b").checked) {
        condition = "1";
    } else if (document.getElementById("u").checked) {
        condition = "2";
    }

    var f = new FormData();
    f.append("s", search.value);
    f.append("t", time);
    f.append("q", qty);
    f.append("c", condition);
    f.append("page", x);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("sort").innerHTML = t;
        }
    }

    r.open("POST", "sortProcess.php", true);
    r.send(f);

}

function clearSort() {
    window.location.reload();
}

function sendId(id) {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "Success") {
                window.location = "updateProduct.php";
            } else {
                alert(t);
            }
        }
    }

    r.open("GET", "sendProductIdProcess.php?id=" + id, true);
    r.send();

}

function updateProduct() {

    var title = document.getElementById("t");
    var qty = document.getElementById("q");
    var delivery_within_colombo = document.getElementById("dwc");
    var delivery_outof_colombo = document.getElementById("doc");
    var description = document.getElementById("d");
    var images = document.getElementById("imageuploader");

    var f = new FormData();
    f.append("t", title.value);
    f.append("q", qty.value);
    f.append("dwc", delivery_within_colombo.value);
    f.append("doc", delivery_outof_colombo.value);
    f.append("d", description.value);

    var img_count = images.files.length;

    for (var x = 0; x < img_count; x++) {
        f.append("i" + x, images.files[x]);
    }

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            alert(t);
        }
    }

    r.open("POST", "updateProductProcess.php", true);
    r.send(f);

}

function basicSearch(x) {
    var txt = document.getElementById("basic_search_txt");
    var select = document.getElementById("basic_search_select");

    var f = new FormData();
    f.append("t", txt.value);
    f.append("s", select.value);
    f.append("page", x);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("basicSearchResult").innerHTML = t;
        }
    }

    r.open("POST", "basicSearchProcess.php", true);
    r.send(f);

}

function advancedSearch(x) {
    var text = document.getElementById("t");
    var category = document.getElementById("c1");
    var brand = document.getElementById("b");
    var model = document.getElementById("m");
    var condition = document.getElementById("c2");
    var colour = document.getElementById("clr");
    var pfrom = document.getElementById("pf");
    var pto = document.getElementById("pt");
    var sort = document.getElementById("s");

    var f = new FormData();
    f.append("t", text.value);
    f.append("c1", category.value);
    f.append("b", brand.value);
    f.append("m", model.value);
    f.append("c2", condition.value);
    f.append("clr", colour.value);
    f.append("pf", pfrom.value);
    f.append("pt", pto.value);
    f.append("s", sort.value);
    f.append("page", x);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("view_area").innerHTML = t;
        }
    }

    r.open("POST", "advancedSearchProcess.php", true);
    r.send(f);

}

function loadMainImg(id) {
    var img = document.getElementById("productImg" + id).src;
    var main = document.getElementById("main_img");
    main.style.backgroundImage = "url(" + img + ")";
}

function checkValue(qty) {
    var input = document.getElementById("qty_input");

    if (input.value <= 0) {
        alert("Quantity must be 1 or more");
        input.value = 1;
    } else if (input.value > qty) {
        alert("Maximum quantity achieved");
        input.value = qty;
    }
}

function qty_inc(qty) {
    var input = document.getElementById("qty_input");
    if (input.value < qty) {
        var newValue = parseInt(input.value) + 1;
        input.value = newValue.toString();
    } else {
        alert("Maximum quantity has achieved");
    }
}

function qty_dec() {
    var input = document.getElementById("qty_input");
    if (input.value > 1) {
        var newValue = parseInt(input.value) - 1;
        input.value = newValue.toString();
    } else {
        alert("Minimum quantity has achieved");
        input.value = 1;
    }
}


function addToWatchlist(id) {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {

        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "removed") {
                document.getElementById("heart" + id).style.className = "text-dark";
                window.location.reload();
            } else if (t == "added") {
                document.getElementById("heart" + id).style.className = "text-danger"
                window.location.reload();
            } else {
                alert(t);
            }
        }

    }

    r.open("GET", "addToWatchlistProcess.php?id=" + id, true);
    r.send();
}

function watchlistSearch(x) {
    var txt = document.getElementById("watchlist_search_txt");

    var f = new FormData();
    f.append("t", txt.value);
    f.append("page", x);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("watchlistSearchResult").innerHTML = t;
        }
    }

    r.open("POST", "watchlistSearchProcess.php", true);
    r.send(f);

}

function recentsSearch(x) {
    var txt = document.getElementById("recents_search_txt");

    var f = new FormData();
    f.append("t", txt.value);
    f.append("page", x);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("recentsSearchResult").innerHTML = t;
        }
    }

    r.open("POST", "recentsSearchProcess.php", true);
    r.send(f);

}


function removeFromWatchlist(id) {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "Success") {
                window.location.reload();
            } else {
                alert(t);
            }
        }
    }

    r.open("GET", "removeWatchlistProcess.php?id=" + id, true);
    r.send();
}


function addToCart(id) {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            alert(t);
        }
    }

    r.open("GET", "addToCartProcess.php?id=" + id, true);
    r.send();

}

function cartQtyUpdate(id) {

    var qty = document.getElementById("cq"+id).value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "Updated") {
                window.location.reload();
            } else {
                alert(t);
                window.location.reload();
            }
        }
    }

    r.open("GET", "cartQtyUpdateProcess.php?id=" + id + "&qty=" + qty, true);
    r.send();

}

function removeFromCart(id) {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "Success") {
                alert("Product removed from cart");
                window.location.reload();
            } else {
                alert(t);
            }
        }
    }

    r.open("GET", "removeCartProcess.php?id=" + id, true);
    r.send();
}


function viewMessages(email) {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("chat_box").innerHTML = t;
        }
    }

    r.open("GET", "viewMsgProcess.php?e=" + email, true);
    r.send();
}


function send_msg() {
    var email = document.getElementById("rmail");
    var txt = document.getElementById("msg_txt");

    var f = new FormData();
    f.append("e", email.innerHTML);
    f.append("t", txt.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "Success") {
                chatbox(email);
            } else {
                alert(t);
            }
        }
    }

    r.open("POST", "sendMsgProcess.php", true);
    r.send(f);

}

function chatbox(email) {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("chat_box").innerHTML = t;
            document.getElementById("msg_txt").value = "";
            var box = document.getElementById("chat_box");
            box.scrollTop = box.scrollHeight;
        }
    }

    r.open("GET", "chatboxProcess.php?e=" + email.innerHTML, true);
    r.send();

}

function payNow(id) {
    var qty = document.getElementById("qty_input").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            var obj = JSON.parse(t);

            var mail = obj["mail"];
            var amount = obj["amount"];

            if (t == "1") {
                alert("Please log in or sign up");
                window.location = "index.php";
            } else if (t == "2") {
                alert("Please update your profile first");
                window.location = "userProfile.php";
            } else {
                // Payment completed. It can be a successful failure.
                payhere.onCompleted = function onCompleted(orderId) {
                    console.log("Payment completed. OrderID:" + orderId);

                    saveInvoice(orderId, id, mail, amount, qty);
                    // Note: validate the payment and show success or failure page to the customer
                };

                // Payment window closed
                payhere.onDismissed = function onDismissed() {
                    // Note: Prompt user to pay again or show an error page
                    console.log("Payment dismissed");
                };

                // Error occurred
                payhere.onError = function onError(error) {
                    // Note: show an error page
                    console.log("Error:" + error);
                };

                // Put the payment variables here
                var payment = {
                    "sandbox": true,
                    "merchant_id": "1221178",    // Replace your Merchant ID
                    "return_url": "http://localhost/eshop/singleProductView.php?id=" + id,     // Important
                    "cancel_url": "http://localhost/eshop/singleProductView.php?id=" + id,     // Important
                    "notify_url": "http://sample.com/notify",
                    "order_id": obj["id"],
                    "items": obj["item"],
                    "amount": amount,
                    "currency": "LKR",
                    "hash": obj["hash"],
                    "first_name": obj["fname"],
                    "last_name": obj["lname"],
                    "email": mail,
                    "phone": obj["mobile"],
                    "address": obj["address"],
                    "city": obj["city"],
                    "country": "Sri Lanka",
                    "delivery_address": obj["address"],
                    "delivery_city": obj["city"],
                    "delivery_country": "Sri Lanka",
                    "custom_1": "",
                    "custom_2": ""
                };

                // Show the payhere.js popup, when "PayHere Pay" is clicked
                // document.getElementById('payhere-payment').onclick = function (e) {
                payhere.startPayment(payment);
                // };
            }

        }
    }

    r.open("GET", "buyNowProcess.php?id=" + id + "&qty=" + qty, true);
    r.send();
}

function saveInvoice(orderId, id, mail, amount, qty) {

    var f = new FormData();
    f.append("o", orderId);
    f.append("i", id);
    f.append("m", mail);
    f.append("a", amount);
    f.append("q", qty);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "1") {
                window.location = "invoice.php?id=" + orderId;
            } else {
                alert(t);
            }
        }
    }

    r.open("POST", "saveInvoice.php", true);
    r.send(f);
}

function checkout(){;

    var ship_fee = document.getElementById("ship_fee").innerHTML;
    var ids = document.getElementById("ids").innerHTML;
    var cart_qty = document.getElementById("cart_qty").innerHTML;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            var obj = JSON.parse(t);

            var orderId = obj["id"];
            var mail = obj["mail"];
            var amount = obj["amount"];

            if (t == "1") {
                alert("Please log in or sign up");
                window.location = "index.php";
            } else if (t == "2") {
                alert("Please update your profile first");
                window.location = "userProfile.php";
            } else {
                // Payment completed. It can be a successful failure.
                payhere.onCompleted = function onCompleted(orderId) {
                    console.log("Payment completed. OrderID:" + orderId);
                    // Note: validate the payment and show success or failure page to the customer
                    saveInvoice2(orderId, mail, amount, ids, cart_qty);
                };

                // Payment window closed
                payhere.onDismissed = function onDismissed() {
                    // Note: Prompt user to pay again or show an error page
                    console.log("Payment dismissed");
                };

                // Error occurred
                payhere.onError = function onError(error) {
                    // Note: show an error page
                    console.log("Error:" + error);
                };

                // Put the payment variables here
                var payment = {
                    "sandbox": true,
                    "merchant_id": "1221178",    // Replace your Merchant ID
                    "return_url": "http://localhost/eshop/cart.php",     // Important
                    "cancel_url": "http://localhost/eshop/cart.php",     // Important
                    "notify_url": "http://sample.com/notify",
                    "order_id": orderId,
                    "items": obj["item"],
                    "amount": amount,
                    "currency": "LKR",
                    "hash": obj["hash"],
                    "first_name": obj["fname"],
                    "last_name": obj["lname"],
                    "email": mail,
                    "phone": obj["mobile"],
                    "address": obj["address"],
                    "city": obj["city"],
                    "country": "Sri Lanka",
                    "delivery_address": obj["address"],
                    "delivery_city": obj["city"],
                    "delivery_country": "Sri Lanka",
                    "custom_1": "",
                    "custom_2": ""
                };

                // Show the payhere.js popup, when "PayHere Pay" is clicked
                // document.getElementById('payhere-payment').onclick = function (e) {
                payhere.startPayment(payment);
                // };
            }

        }
    }

    r.open("GET", "checkoutProcess.php?ids=" + ids + "&ship_fee=" + ship_fee+"&qty="+cart_qty, true);
    r.send();

}

function saveInvoice2(orderId, mail, amount, ids, cart_qty) {

    var f = new FormData();
    f.append("o", orderId);
    f.append("m", mail);
    f.append("a", amount);
    f.append("q", cart_qty);
    f.append("ids", ids);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "1") {
                window.location = "checkoutInvoice.php?id=" + ids + "&oid=" + orderId;
            } else {
                alert(t);
            }
        }
    }

    r.open("POST", "savecheckoutInvoice.php", true);
    r.send(f);
}

function printInvoice() {
    var body = document.body.innerHTML;
    var page = document.getElementById("page").innerHTML;
    document.body.innerHTML = page;
    window.print();
    document.body.innerHTML = body;
}

var md;
function addFeedback(id) {
    var feedbackModal = document.getElementById("feedbackModel" + id);
    md = new bootstrap.Modal(feedbackModal);
    md.show();
}

function saveFeedback(id) {

    var type;
    if (document.getElementById("type1" + id).checked) {
        type = 1;
    } else if (document.getElementById("type2" + id).checked) {
        type = 2;
    } else if (document.getElementById("type3" + id).checked) {
        type = 3;
    }

    var feedback = document.getElementById("feed" + id);

    var f = new FormData();
    f.append("t", type);
    f.append("p", id);
    f.append("f", feedback.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == '1') {
                alert("Thank You for Your Feedback!");
                md.hide();
            } else {
                alert(t);
            }
        }
    }

    r.open("POST", "saveFeedbackProcess.php", true);
    r.send(f);

}

// Admin Verification
var av;
function adminVerification() {
    var email = document.getElementById("e");

    var f = new FormData();
    f.append("e", email.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "Success") {
                var adminVerificationModal = document.getElementById("verificationModal");
                av = new bootstrap.Modal(adminVerificationModal);
                av.show();
            } else {
                document.getElementById("msg").innerHTML = " " + t;
                document.getElementById("msg").className = "bi bi-x-octagon-fill fs-5";
                document.getElementById("msgdiv").className = "opacity-100";
                document.getElementById("alertdiv").className = "alert alert-danger";

            }
        }
    }

    r.open("POST", "adminVerificationProcess.php", true);
    r.send(f);
}

function verify() {
    var verification = document.getElementById("vcode");

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                av.hide();
                window.location = "adminPanel.php";
            } else {
                alert(t);
            }
        }
    }

    r.open("GET", "verificationProcess.php?v=" + verification.value, true);
    r.send();
}

function blockUser(email){

    var request = new XMLHttpRequest();

    request.onreadystatechange = function (){
        if(request.readyState == 4){
            var txt = request.responseText;
            if(txt == "blocked"){
                document.getElementById("ub"+email).innerHTML = "Unblock";
                document.getElementById("ub"+email).classList = "btn btn-success";
            }else if(txt == "unblocked"){
                document.getElementById("ub"+email).innerHTML = "block";
                document.getElementById("ub"+email).classList = "btn btn-danger";
            }else{
                alert(txt);
            }
            
        }
    }

    request.open("GET","userBlockProcess.php?email="+email,true);
    request.send();

}

function blockProduct(id){

    var request = new XMLHttpRequest();

    request.onreadystatechange = function (){
        if(request.readyState == 4){
            var txt = request.responseText;
            if(txt == "Deactive"){
                document.getElementById("pb"+id).innerHTML = "Active";
                document.getElementById("pb"+id).classList = "btn btn-success";
            }else if(txt == "Active"){
                document.getElementById("pb"+id).innerHTML = "Deactive";
                document.getElementById("pb"+id).classList = "btn btn-danger";
            }else{
                alert(txt);
            }
            
        }
    }

    request.open("GET","productBlockProcess.php?id="+id,true);
    request.send();

}

var pm;
function viewProductModal(id) {
    var m = document.getElementById("viewProductModal"+id);
    pm = new bootstrap.Modal(m);
    pm.show();
}

var cm;
function addNewCategory() {
    var m = document.getElementById("addCategoryModal");
    cm = new bootstrap.Modal(m);
    cm.show();
}

var vc;
var e;
var n;
function verifyCategory() {
    var ncm = document.getElementById("addCategoryVerificationModal");
    vc = new bootstrap.Modal(ncm);

    e = document.getElementById("e").value;
    n = document.getElementById("n").value;

    var f = new FormData();
    f.append("email", e);
    f.append("name", n);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "Success") {
                cm.hide();
                vc.show();
            } else {
                alert(t);
            }
        }
    }

    r.open("POST", "addNewCategoryProcess.php", true);
    r.send(f);
}

function saveCategory() {
    var txt = document.getElementById("txt").value;

    var f = new FormData();
    f.append("t", txt);
    f.append("e", e);
    f.append("n", n);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t = "Success") {
                vc.hide();
                window.location.reload();
            } else {
                alert(t);
            }
        }
    }

    r.open("POST", "saveCategoryProcess.php", true);
    r.send(f);
}

function changeStatus(id) {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == 1) {
                document.getElementById("btn" + id).innerHTML = "Packing";
                document.getElementById("btn" + id).classList = "btn btn-warning fw-bold mt-1 mb-1";
            } else if (t == 2) {
                document.getElementById("btn" + id).innerHTML = "Dispatch";
                document.getElementById("btn" + id).classList = "btn btn-info fw-bold mt-1 mb-1";
            } else if (t == 3) {
                document.getElementById("btn" + id).innerHTML = "Shipping";
                document.getElementById("btn" + id).classList = "btn btn-primary fw-bold mt-1 mb-1";
            } else if (t == 4) {
                document.getElementById("btn" + id).innerHTML = "Delivered";
                document.getElementById("btn" + id).classList = "btn btn-danger fw-bold mt-1 mb-1 disabled";
            } else {
                alert(t);
            }
        }
    }

    r.open("GET", "changeInvoiceStatusProcess.php?id=" + id, true);
    r.send();
}

function searchInvoiceId() {
    var txt = document.getElementById("searchtxt").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("viewArea").innerHTML = t;
        }
    }

    r.open("GET", "searchInvoiceIdProcess.php?id=" + txt, true);
    r.send();
}

function findSellings(x) {

    var from = document.getElementById("from").value;
    var to = document.getElementById("to").value;

    var f = new FormData();
    f.append("f", from);
    f.append("t", to);
    f.append("page", x);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("viewArea").innerHTML = t;
        }
    }

    r.open("POST", "findSellingsProcess.php", true)
    r.send(f);

}

function productSearch(x) {
    var txt = document.getElementById("product_search_txt");

    var f = new FormData();
    f.append("t", txt.value);
    f.append("page", x);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("productSearchResult").innerHTML = t;
        }
    }

    r.open("POST", "productSearchProcess.php", true);
    r.send(f);
}

function userSearch(x) {
    var txt = document.getElementById("user_search_txt");

    var f = new FormData();
    f.append("t", txt.value);
    f.append("page", x);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("userSearchResult").innerHTML = t;
        }
    }

    r.open("POST", "userSearchProcess.php", true);
    r.send(f);
}

function cartSearch(x) {
    var txt = document.getElementById("cart_search_txt");

    var f = new FormData();
    f.append("t", txt.value);
    f.append("page", x);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("cartSearchResult").innerHTML = t;
        }
    }

    r.open("POST", "cartSearchProcess.php", true);
    r.send(f);
}

var mm;
function viewMsgModal(email){
    var m = document.getElementById("userMsgModal"+email);
    mm = new bootstrap.Modal(m);
    mm.show();
}

var cam;
function contactAdmin(email){
    var m = document.getElementById("contactAdmin");
    cam = new bootstrap.Modal(m);
    cam.show();
}

function sendAdminMsg(email){
    var txt = document.getElementById("msgtxt"+email).value;

    var f = new FormData();
    f.append("t",txt);
    f.append("r",email);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function(){
        if(r.readyState == 4){
            var t = r.responseText;
            if(t == "success"){
                msgbox(email);
                msgbox2(email);
            }else{
                alert (t);
            }
            
        }
    }

    r.open("POST","sendAdminMessageProcess.php",true);
    r.send(f);

}

function msgbox(email) {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("msg_box"+email).innerHTML = t;
            document.getElementById("msgtxt"+email).value = "";
            var box = document.getElementById("msg_box"+email);
            box.scrollTop = box.scrollHeight;
        }
    }

    r.open("GET", "msgboxProcess.php?e=" + email, true);
    r.send();

}

function msgbox2(email) {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("msg_box2"+email).innerHTML = t;
            document.getElementById("msgtxt"+email).value = "";
            var box = document.getElementById("msg_box2"+email);
            box.scrollTop = box.scrollHeight;
        }
    }

    r.open("GET", "msgbox2Process.php?e=" + email, true);
    r.send();

}