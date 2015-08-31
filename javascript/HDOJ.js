//Javascript Document

function encodeSource()
{
	var str = document.getElementById("code").value;
	if (str.length < 220)
	{
		alert("Code length too short!")
		return false;
	}
	return true;
}
