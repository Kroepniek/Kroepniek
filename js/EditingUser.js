function EditUserInfo(index, index2, ID)
{
    if (index2 == false)
    {
        var cur_input = document.getElementById('user-info');
        cur_input = cur_input.children[index];
        
        var cur_input_name = cur_input.name;
        var cur_input_value = cur_input.value;
        //console.log(cur_input);
        SendRequest(cur_input_name, cur_input_value, ID, SendMessage);
    }
    else
    {
        var cur_input_1 = document.getElementById('user-info');
        var cur_input_2 = document.getElementById('user-info');

        cur_input_1 = cur_input_1.children[index];
        cur_input_2 = cur_input_2.children[index2];
        
        var cur_input_1_name = cur_input_1.name;
        var cur_input_1_value = cur_input_1.value;

        var cur_input_2_name = cur_input_2.name;
        var cur_input_2_value = cur_input_2.value;

        //console.log(cur_input_1);
        //console.log(cur_input_2);
        SendRequest(cur_input_1_name, cur_input_1_value, ID, SendMessage);
        SendRequest(cur_input_2_name, cur_input_2_value, ID, SendSecMessage);
    }
}

function SendRequest(col, val, ID, func)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            func(this.responseText);
        }
    };
    xmlhttp.open("POST", "EditUser.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("col=" + col + "&val=" + val + "&id=" + ID);
}

function SendMessage(msg)
{
    var user_edit_error = document.getElementById('user-edit-error');
    if (msg.includes("successfully"))
    {
        user_edit_error.style.color = "rgb(128, 255, 128)";
    }
    else if (msg.includes("error") || msg.includes("valid"))
    {
        user_edit_error.style.color = "rgb(255, 128, 128)";
    }
    else
    {
        user_edit_error.style.color = "rgb(255, 255, 255)";
    }
    user_edit_error.innerHTML = msg;
    setTimeout(function(){
        user_edit_error.innerHTML = "";
    }, 3000);
}

function SendSecMessage(msg)
{
    var user_edit_error = document.getElementById('user-edit-error');
    var user_edit_error_text = user_edit_error.innerHTML;
    
    if (user_edit_error_text == "There is nothing changed")
    {
        if (msg.includes("successfully"))
        {
            user_edit_error.style.color = "rgb(128, 255, 128)";
        }
        else if (msg.includes("error") || msg.includes("valid"))
        {
            user_edit_error.style.color = "rgb(255, 128, 128)";
        }
        else
        {
            user_edit_error.style.color = "rgb(255, 255, 255)";
        }

        user_edit_error.innerHTML = msg;
    }
    else
    {
        user_edit_error.innerHTML = user_edit_error_text + "<br>" + msg;
    }
}