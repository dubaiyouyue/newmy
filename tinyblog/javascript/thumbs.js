function fiximage(thumbs_size) {
	var max = thumbs_size.split('x');
	var fixwidth = max[0];
	var fixheight = max[1];
	imgs = document.getElementsByTagName('img');
	for(i=0;i<imgs.length;i++) {
		w=imgs[i].width;h=imgs[i].height;
		if(w>fixwidth) { imgs[i].width=fixwidth;imgs[i].height=h/(w/fixwidth);}
		if(h>fixheight) { imgs[i].height=fixheight;imgs[i].width=w/(h/fixheight);}
	}
}