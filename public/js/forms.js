function inputhash(form, password, name) {
   var p = document.createElement("input");
   if(password.value.length > 0) {
    form.appendChild(p);
    p.name = name;
    p.type = "hidden"
    p.value = hex_sha512(password.value);
    password.value = "";
   }
}

function loadSpinner(btn) {
  btn.click(function(event) {
    event.preventDefault()
    btn.toggleClass("d-none");
    $("#spinner").toggleClass("d-none");
  });
}

const pattern = /^(?:[0-9]+[a-z]|[a-z]+[0-9])[a-z0-9]*$/i;

function validateSignupForm(form, password, password_confirm) {
    let isFormOk = true;
    const email = $(".container form input#email");
    const name = $(".container form input#name");
    const surname = $(".container form input#surname");
    const p = $(".container form input#password");
    const p_confirm = $(".container form input#p_confirm");
    const checkbox = $('input#sellerCheckBox');
    const iva = $('input#iva');
    const company = $('input#company');
    $("input#email + div").remove();
    $("input#password + div").remove();
    $("input#name + div").remove();
    $("input#surname + div").remove();
    $("input#p_confirm + div").remove();
    $("input#iva + div").remove();
    $("input#company + div").remove();
    p.removeClass("is-invalid");
    email.removeClass("is-invalid");
    name.removeClass("is-invalid");
    surname.removeClass("is-invalid");
    iva.removeClass("is-invalid");
    company.removeClass("is-invalid");
    

    if(email.val()==undefined || email.val().length<5){
        email.parent().append(
          '<div class="invalid-feedback">Il campo email deve essere di almeno 5 caratteri!</div>');
        isFormOk = false;
        email.addClass("is-invalid");
    }


    if(p.val()==undefined || p.val().length<8 /*|| !$(p).test(p.val())*/){
        p.parent().append(
          '<div class="invalid-feedback">Password deve essere almeno 8 caratteri e deve contenere almeno una lettera ed un numero!</div>');
        isFormOk = false;
        $(password).addClass("is-invalid");
    } else {
        isFormOk = checkPassword($(p_confirm), $(p)) ? isFormOk : false;
    }

    if(checkbox[0].checked) {
        isFormOk = checkEmptyField(iva) ? isFormOk : false;
        isFormOk = checkEmptyField(company) ? isFormOk : false;
    }

    isFormOk = checkEmptyField(name) ? isFormOk : false;
    isFormOk = checkEmptyField(surname) ? isFormOk : false;
    isFormOk = checkEmptyField(p_confirm) ? isFormOk : false;

    if(isFormOk){
      inputhash(form, password, "p");
      inputhash(form, password_confirm, "p_confirm");
      form.submit();
    } else {
      $("#signupBtn").toggleClass("d-none");
      $("#spinner").toggleClass("d-none");
    }
}

function validateLoginForm(form, password) {
    let isFormOk = true;
    const email = $(".container form input#email");
    const p = $(".container form input#password");
    $("input#email + div").remove();
    $("input#password + div").remove();
    p.removeClass("is-invalid");
    email.removeClass("is-invalid");

    isFormOk = checkEmptyField(email) ? isFormOk : false;
    isFormOk = checkEmptyField(p) ? isFormOk : false;

    if(isFormOk){
      inputhash(form, password, "p");
      form.submit();
    } else {
      $("#loginBtn").toggleClass("d-none");
      $("#spinner").toggleClass("d-none");
    }
}

function validateUserPasswordForm(form, pass, new_pass, confirm_pass) {
    let isFormOk = true;
    const p_confirm = $(".container form input#confirm_password");
    const p_new = $(".container form input#new_password");
    const p = $(".container form input#password");
    $("input#confirm_password + div").remove();
    $("input#password + div").remove();
    $("input#new_password + div").remove();
    p.removeClass("is-invalid");
    p_new.removeClass("is-invalid");
    p_confirm.removeClass("is-invalid");

    isFormOk = checkEmptyField(p_new) ? isFormOk : false;
    isFormOk = checkEmptyField(p_confirm) ? isFormOk : false;
    isFormOk = checkEmptyField(p) ? isFormOk : false;

    if(isFormOk){
      inputhash(form, pass, "p");
      inputhash(form, new_pass, "p_new");
      inputhash(form, confirm_pass, "p_confirm");
      form.submit();
    } else {
      $("#changePassBtn").toggleClass("d-none");
      $("#spinner").toggleClass("d-none");
    }
}

function checkEmptyField(field) {
  if(field.val()==undefined || field.val().length<1) {
    field.parent().append('<div id="invalid-e" class="invalid-feedback">Il campo non pu&ograve essere lasciato vuoto!</div>');
    $("input#" + field[0].id).addClass("is-invalid");
    return false;
  }
  return true;
}

function checkPassword(p1, p2) {
    if(p1.val().length > 0 && p2.val().length > 0) {
      p1.removeClass("is-invalid");
      p2.removeClass("is-invalid");
      $('#invalid-confirm').remove();
      $('#invalid-p').remove();
      if(p1.val().localeCompare(p2.val())) {
          p1.parent().append('<div id="invalid-confirm" class="invalid-feedback">Passwords do not match</div>');
          p1.addClass("is-invalid");
          p2.parent().append('<div id="invalid-p" class="invalid-feedback">Passwords do not match</div>');
          p2.addClass("is-invalid");
          return false;
      } else {
          $('#invalid-confirm').remove();
          $('#invalid-p').remove();
          p1.addClass("is-valid");
          p2.addClass("is-valid");
          return true;
      }
    }
}

function addPasswordListener(p1, p2) {
    p1.onkeyup = function() {
      checkPassword($(p1), $(p2));
    }
    p2.onkeyup = function() {
      checkPassword($(p1), $(p2));
    }
}
