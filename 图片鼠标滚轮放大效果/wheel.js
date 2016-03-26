function fnWheel(obj,fncc)
{
	obj.onmousewheel = fn;
	if(obj.addEventListener)
	{
		obj.addEventListener('DOMMouseScroll',fn,false);
	}

	function fn(ev)
	{
		var oEvent = ev || window.event;
		var down = true;

		if(oEvent.detail)
		{
			down = oEvent.detail>0
		}
		else
		{
			down = oEvent.wheelDelta<0
		}

		if(fncc)
		{
			fncc.call(this,down,oEvent);
		}

		if(oEvent.preventDefault)
		{
			oEvent.preventDefault();
		}

		return false;
	}

	
}
