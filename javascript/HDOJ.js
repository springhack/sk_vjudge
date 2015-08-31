//Javascript Document

function encodeSource()
{
	var str = document.getElementById("code").value;
	if (str.length < 20)
	{
		alert("Code length too short!")
		return false;
	}
	return true;
}
