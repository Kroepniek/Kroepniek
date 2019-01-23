function EditUserInfo(index)
{
    var cur_input = document.getElementById('user-info');
    cur_input = cur_input.children[index];
    console.log(cur_input.value);
}