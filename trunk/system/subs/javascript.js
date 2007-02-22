// Start of file: system/subs/javascript.js

// Open Popup
function ecOpenPopup(title,text,button)
{
	var l = (screen.width-200) / 2;
	var t = (screen.height-100) / 2;
	window.open('plugins/system/popup.php?title='+title+'&text='+text+'&button='+button , 'openpopup', 'toolbar=no,menubar=no,status=yes,scrollbars=no,width=200,height=100,left='+l+',top='+t)
}

// Check all Checkboxes
function ecCheckAll(formname)
{
	for (var i = 0; i < document.getElementById(formname).elements.length ; i++)
	{
		var e = document.getElementById(formname).elements[i];
		if ((e.name != 'allbox') && (e.type=='checkbox'))
		{
			e.checked = document.getElementById(formname).allbox.checked;
		}
	}
}

// Change Source
function ecChangesrc(Id,Path)
{
	document.getElementById(Id).src = Path;
}

// Passwordcheck
function ecPassword(sP)
{
	count = 0
	if(sP.length > 5)
	{
		count++;
	}
	var result1 = sP.search(/\D/);
	if (result1 != -1 && sP.length > 5)
	{
		count++;	
	}  
	up = sP.toUpperCase();
	low = sP.toLowerCase();
	if(sP != up && sP != low && sP.length > 5)
	{
		count++;
	}
	var result2 = sP.search(/\d/);
	if (result2 != -1 && sP.length > 5)
	{
  		count++;
	}
	ecChangesrc('i1','icons/default/16/shield2.png')
	ecChangesrc('i2','icons/default/16/shield2.png')
	ecChangesrc('i3','icons/default/16/shield2.png')
	if (count > 1) 
	{
		ecChangesrc('i1','icons/default/16/shield.png')
	}
	if (count > 2) 
	{
		ecChangesrc('i2','icons/default/16/shield.png')
	}
	if (count > 3) 
	{
		ecChangesrc('i3','icons/default/16/shield.png')
	}
}

// Dem Body das onLoad-Event hinzufügen
addEvent(this, 'load', function() { hideTabOnLoad() });

// Funktion zur Registrierung von Event Handler
function addEvent(jsObject, jsType, jsFunction) {
	if (jsObject.addEventListener)
		jsObject.addEventListener(jsType, jsFunction, false);
	else if (jsObject.attachEvent) {
		jsObject["e"+jsType+jsFunction] = jsFunction;
		jsObject[jsType+jsFunction] = function() { jsObject["e"+jsType+jsFunction](window.event); }
		jsObject.attachEvent("on"+jsType, jsObject[jsType+jsFunction]);
	}
}

// Tabboxen beim Seitenaufruf initialisieren
function hideTabOnLoad() {	
	// Sämtliche Div Tags vom Document suchen
	var jsTempDiv = document.getElementsByTagName('div');
	// Array für die Tabbox Objecte
	var jsTabBoxArray = new Array();
	
	// Alle Div-Tabbox Elemente finden
	for(var i=0; i<jsTempDiv.length; i++) {
		// Tabboxen ermitteln
		if(jsTempDiv[i].className == 'clickTabBox') {
			jsTabBoxArray[jsTabBoxArray.length] = jsTempDiv[i];
		}
	}
		
	// Sämtliche vorhandene Tabboxen bearbeiten
	for(var i=0; i<jsTabBoxArray.length; i++) {
		// Kinderelemente der Tabbox ermitteln
		var jsTempTabBoxElements = jsTabBoxArray[i].childNodes;
		// Array für die Tab Objecte
		var jsTabArray = new Array();
				
		// Kinderelemente der Tabbox überprüfen
		for(var x=0; x<jsTempTabBoxElements.length; x++) {			
			// Ermitteln der Tabbox Navigation
			if(jsTempTabBoxElements[x].tagName == 'UL') {
				// Die Class der Tabbox hinzufügen
				jsTempTabBoxElements[x].className = 'clickTabNav';
				
				// Alle Navigationselemente ermitteln
				jsTempAllNavElements = jsTempTabBoxElements[x].getElementsByTagName('li');
				// Dem ersten li Element der Navigation die activeTab Class zuweissen
				jsTempAllNavElements[0].className = 'activeTab';
				
				// Der Navigation die Events hinzufügen
				for(var y=0; y<jsTempAllNavElements.length; y++) {
					addEvent(jsTempAllNavElements[y], 'click', function() { changeTab(this) });
					jsTempAllNavElements[y].getElementsByTagName('a')[0].href = 'javascript: void(0)';
										
					createTabTpl(jsTempAllNavElements[y], 'tabNavWrapper', 6);
				}

			// Ermitteln der Tabs (div-elemente)
			} else if (jsTempTabBoxElements[x].tagName == 'DIV') {
				jsTabArray[jsTabArray.length] = jsTempTabBoxElements[x];
			}
		}
		
		// Alle Tabs der jeweiligen Tabbox bearbeiten
		for(var x=0; x<jsTabArray.length; x++) {	
			// Erster Tab sichtbar machen
			var jsTempTabStatus = (x==0) ? "block" : "none";
			jsTabArray[x].style.display = jsTempTabStatus;
						
			jsTempTabObj = createTabTpl(jsTabArray[x], 'tabWrapper', 3, 'tab');			
		}
	}
}

function changeTab(jsElement) {
	// Aktives LI - Element ermitteln
	var jsActNav = jsElement;
	// Sämtliche LI - Elemente des aktiven Tabs ermitteln
	var jsTabNav = jsElement.parentNode.getElementsByTagName('li');
	// Sämtliche Objecte der activen Tabbox ermitteln
	var jsTabBox = jsElement.parentNode.parentNode.childNodes;
	
	// Variabel für aktuelle Tabposition
	var jsSelectedNav;
	
	// Aktiv-Classe dem angewählten LI-Elements zuweisen
	for(var i=0; i<jsTabNav.length;i++) {
		if(jsTabNav[i] == jsActNav) {
			jsTabNav[i].className = 'activeTab';
			jsSelectedNav = i;
		} else {
			jsTabNav[i].className = '';
		}
	}

	// Array für die Tab Objecte
	var jsTabArray = new Array();

	// Alle Tabs der aktiven Tabbox ermitteln und in Array speichern
	for(var i=0; i<jsTabBox.length;i++) {
		if(jsTabBox[i].tagName == 'DIV' || jsTabBox[i].className == 'clickTab') {
			jsTabArray[jsTabArray.length] = jsTabBox[i];
		}
	}
	
	// Aktiver Tav anzeigen, die anderen ausblenden
	for(var i=0; i<jsTabArray.length;i++) {
		if(i == jsSelectedNav) {
			jsTabArray[i].style.display = 'block';
		} else {
			jsTabArray[i].style.display = 'none';
		}
	}	
}

// Tab Template Erstellen
function createTabTpl(jsObject, jsClassPraefix, jsTplCount, jsType) {
	// Array für die Templates
	var jsTplArray = new Array();
	// InnerHTML des Objects zwischenspeichern
	var jsTempObjectContent = jsObject.innerHTML;
	
	// Div Templates generieren und Classe zuweisen
	for(var i=1; i<=jsTplCount;i++) {
		jsTplArray[i] = document.createElement('div');
		jsTplArray[i].className = jsClassPraefix + i;
	}
	
	// InnerHTML des Objects löschen
	jsObject.innerHTML = '';
	
	// Variabel um Object temporär abzuspeichern
	var jsTempTpl = jsObject;
	// Templates im LI Element verschachteln
	for(var i=1; i<jsTplArray.length;i++) {
		jsTempTpl.appendChild(jsTplArray[i]);
		jsTempTpl = jsTempTpl.childNodes.item(0);
	}
	
	// Wenn das Object ein tab ist -> Ein weiterer Div hinzufügen
	if(jsType == 'tab') {
		// Tab-Inner Div erzäugen (Für Tab Rand)
		var jsInnerClickTab = document.createElement('div');
		jsInnerClickTab.className = 'clickTab-inner';
		jsTempTpl.appendChild(jsInnerClickTab);
		jsTempTpl = jsTempTpl.childNodes.item(0);
	}
	
	// InnerHTML wieder einfügen
	jsTempTpl.innerHTML = jsTempObjectContent;
}








function ecMakeVisible(inputname,object)
{
	if (document.Form.elements[inputname].value != "")
	{
		var ID = document.Form.elements[inputname].value;
		document.getElementById(ID).style.display='none';
		document.Form.elements[inputname].value = "";
	}
	if(document.getElementById(object).style.display=='none')
	{
		document.getElementById(object).style.display='block';
		document.Form.elements[inputname].value = object;
	}
	else document.getElementById(object).style.display='none';
}

//Dynamic Map-Inputfield add
var zaehler_map = 0;
function ecDynamicMapInput(tabid,typ,start)
{
	if(typ == 1)
	{
		NewRow = document.getElementById(tabid).lastChild.cloneNode(true);
		document.getElementById(tabid).appendChild (NewRow);
		zaehler_map++;
	}
	if(typ == 2)
	{
		if(zaehler_map+start > 0)
		{
			DeleteRow = document.getElementById(tabid).lastChild;
			document.getElementById(tabid).removeChild (DeleteRow);
			zaehler_map--;
		}
	}
}

//Dynamic Inputfield add
var zaehler=0;
function ecDynamicInput(tabid,typ,start)
{
	if(typ == 1)
	{
		c=document.getElementById(tabid);
		d=document.createElement('div');
		zaehler++;
		d.id='def'+zaehler;
		c.appendChild(d);
		i=document.createElement('input');
			i.type='text';
			i.name=tabid+'[]';
		d.appendChild(i);
	}
	if(typ == 2)
	{
		if(zaehler+start>0)
		{
			c=document.getElementById(tabid);
			c.removeChild(document.getElementById('def'+zaehler));
			zaehler--;
		}
	}
}

//Dynamic Fileadd for Uploads
var filecount = 0;
function ecFileInput(bodyId,typ)
{
	fx = document.getElementById(bodyId);
 
	tr  = document.createElement("tr");
	td   = document.createElement("td");

	inp  = document.createElement("input");
	inp.type = 'file';
	inp.name = 'file' + filecount;

	td.appendChild(inp);
	tr.appendChild(td);
	fx.appendChild(tr);

	filecount++;
}

//Input mit auswahlmöglichkeiten für Maps
ecAjaxMapwahl = function(searchopt, rows, data)
{
	document.write('<div ');
	document.write('id="ajaxselectboxcon" ');
	document.write('style="');
	document.write('position:absolute;');
	document.write('left:650px;');
	document.write('top:380px;');
	document.write('visibility:hidden;');
	document.write('display:none;');
	document.write('">');
	document.write('<form name="ajaxform">');
	document.write('<select name="ajaxselectbox" size="'+rows+'">');
	document.write('</select>');
	document.write('</form>');
	document.write('</div>');
	document.data = data;
	document.searchopt = searchopt.toLowerCase();
};

ecRunAjaxMapwahl = function(e)
{
	if (typeof(document.body.scrollTop) == 'number' || window.opera)
	{
		if (window.event)
		{
			if (!event.x)
			{
				var px = event.clientX;
				var py = event.clientY;
			} 
			else 
			{
				if (event.clientY>event.screenY)
				{
					var px = document.body.scrollLeft+event.screenX-2;
					var py = document.body.scrollTop+event.screenY-138;
				}
				else
				{
					var px = document.body.scrollLeft+event.clientX;
					var py = document.body.scrollTop+event.clientY;
				}
			}
			var current = event.srcElement;
		}
		else
		{
			var px = document.body.scrollLeft+e.clientX;
			var py = document.body.scrollTop+e.clientY;
			var current = e.target;
		}
	}
	else
	{
		var px = window.pageXOffset+e.clientX;
		var py = window.pageYOffset+e.clientY;
		var current = e.target;
	}
	var obj = document.getElementById('ajaxselectboxcon');
	if (current.type == 'text' || current.type == 'textarea')
	{
		var sbox = document['ajaxform']['ajaxselectbox'];
		obj.data = document.data;
		obj.current = current;
		obj.sbox = sbox;
		obj.updatebox = function()
		{
			var tmp = [];
			for (var x in this.data[this.current.name]) 
			{
				var currentvalue = this.current.value.toLowerCase();
				var currentdata = this.data[this.current.name][x];
				if (document.searchopt == 'first')
				{
					if (currentdata.toLowerCase().substr(0, currentvalue.length) == currentvalue)
					{
						tmp[tmp.length] = currentdata;
					}
				}
				else if (document.searchopt == 'full')
				{
					if(currentdata.toLowerCase().indexOf(currentvalue)>-1)
					{
						tmp[tmp.length] = currentdata;
					}
				}
			}
			if (tmp.length>0)
			{
				for (var x=this.sbox.options.length-1; x>=0; --x)
				{
					this.sbox.options[x] = null;
				}
				for (var x=0; x<tmp.length; ++x)
				{
					this.sbox.obj = this;
					this.sbox.field = this.current;
					this.sbox.options[x] = new Option(tmp[x], tmp[x]);
					this.sbox.onchange = function()
					{
						this.field.value = this.value;
						this.obj.style.visibility = 'hidden';
						this.obj.style.display = 'none';
						for(var x=this.options.length-1; x>=0; --x)
						{
							this.options[x] = null;
						}
					}
				}
			}
			else
			{
				this.style.visibility = 'hidden';
				this.style.display = 'none';
			}
		};
		current.obj = obj;
		current.onkeyup = function()
		{
			this.obj.style.visibility = 'visible';
			this.obj.style.display = 'block';
			this.obj.updatebox();
		};
		current.onclick = function()
		{
			this.obj.style.visibility = 'hidden';
			this.obj.style.display = 'none';
		};
		if (obj.sbox.options.length>0)
		{
			obj.style.visibility = 'visible';
			obj.style.display = 'block';

		}
		else
		{
			obj.style.visibility = 'hidden';
			obj.style.display = 'none';
		}
		obj.style.top = py;
		obj.style.left = px+40;
	}
}

if (document.captureEvents) 
{
	document.captureEvents(Event.CLICK);
}

document.onclick = ecRunAjaxMapwahl;


function ecMapwahl(daten)
{
	ecAjaxMapwahl('FIRST', 6, {'map[]':daten});
}



// End of file: system/subs/javascript.js