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
// End of file: system/subs/javascript.js