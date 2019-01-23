function validateForm(form)
{
    console.log("pl");
    
    var form_to_validate = form;
    var isOk = false;
    var ok = "ok";

    if (form_to_validate.name == "loginForm")
    {
        isOk = (form_to_validate["nick"].value.length < 1 ? false : true);
        isOk = (form_to_validate["pass"].value.length < 1 ? false : true);
    }
    else
    {
        isOk = (form_to_validate["nick"].value.length < 1 ? false : true);
        isOk = (form_to_validate["name"].value.length < 1 ? false : true);
        isOk = (form_to_validate["lastname"].value.length < 1 ? false : true);
        isOk = (form_to_validate["email"].value.length < 1 ? false : true);
        isOk = (form_to_validate["pass"].value.length < 1 ? false : true);
        isOk = (form_to_validate["repeat_pass"].value.length < 1 ? false : true);
    }

    return isOk;
}