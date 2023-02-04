	where('name','test')->get;


	whereBetween('id',[1,3])->get;
	
	
	whereNotBetween('id',[2,4])->get;