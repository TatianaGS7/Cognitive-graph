// настройка SVG для D3
var colors = d3.scale.category20(); // использование цветовой гаммы,которой располагает библиотека,для ДЕ

var svg = d3.select('.graph')  
  .append('svg')           //добавляется Svg
  .attr('width', 510)     
  .attr('height', 400); 

// инициализация расположения ОБ "силой" (force) D3 
var force = d3.layout.force()  //позиционирование связанных вершин методом физического моделирования
    .nodes(nodes)  //установка массива вершин, участвующих в симуляции
    .links(links)  //установка массива связей между вершинами.
    .size([510, 400])  //установка размер макета в "х" и "у" координатах
    .linkDistance(100)  //расстояние между ДЕ со связями
    .charge(-400)      //становить силу заряда
    .on('tick', ticks); //функция ticks - создание связей

// определение указателей для связей (стрелок)
svg.append('svg:defs').append('svg:marker')  //добавляется defs(хранение графич элементов) и marker(отметки на линиях path)
    .attr('id', 'end-arrow') //присваиваем маркеру имя "направление налево" 
    .attr('viewBox', '0 -5 10 10')   //определется новая область для рисования и система координат
    .attr('refX', 6)                 // refX перемещает влево курсор по оси абцисс
    .attr('markerWidth', 3)          //ширина прямоугольной области, в кот располагается маркер
    .attr('markerHeight', 3)         //высота прямоугольной области
    .attr('orient', 'auto')          //маркер автоматич поворачивается при изменении направления линии
  .append('svg:path')                //добавл элемент path-создание сложных геомет фигур
    .attr('d', 'M0,-5L10,0L0,5')     // Точки фигуры задаются в атрибуте d -рисование стрелки
    .attr('fill', '#000');          //цвет стрелки

// аналогично для другой стрелки 
svg.append('svg:defs').append('svg:marker')   
    .attr('id', 'start-arrow')
    .attr('viewBox', '0 -5 10 10')
    .attr('refX', 4)
    .attr('markerWidth', 3)
    .attr('markerHeight', 3)
    .attr('orient', 'auto')
  .append('svg:path')       
    .attr('d', 'M10,-5L0,0L10,5')
    .attr('fill', '#000');

// перетаскивание линии стрелки
var drag_drop_line = svg.append('svg:path')   //добавл элемент path-создание сложных геомет фигур
  .attr('class', 'link drag_drop_line hidden') //скрытая линия  
  .attr('d', 'M0,0L0,0');

// обращение для соединия связей и ДЕ
var path = svg.append('svg:g').selectAll('path'),
    circle = svg.append('svg:g').selectAll('g'); //ДЕ сгруппированы в одну группу и выделены

// назначение событий для мыши
var node_selected = null,   //выбранная ДЕ
    link_selected = null,   //выбранная стрелка
    link_mousedown = null,  //нажатие  на стрелку
    node_mousedown = null,  //нажатие на ДЕ
    node_mouseup = null;    //Нажатая кнопка отпущена (ДЕ)


//ФУНКЦИИ

function resetMouseVars() {  // мышь не активна
  node_mousedown = null;
  node_mouseup = null;
  link_mousedown = null;
}

// обновление расположения "силы" (вызывается автоматически при каждой итерации-повторе)
function ticks() {
  // возникновение стрелки(связи) от центра узла
  path.attr('d', function(d) {  // атрибуту d задается значение d(значение набора данных). назначение движения стрелке  
    var dX = d.target.x - d.source.x, //конец-начало-пройденный путь по оси х
        dY = d.target.y - d.source.y, //по оси у(от одной ДЕ, до др точно в цель)
        dist = Math.sqrt(dX * dX + dY * dY), //дистанция-гипотенуза треугольника
        nX = dX / dist,
        nY = dY / dist,
    sourceContents = 11;
    targetContents = 18;
    sourceX = d.source.x + (sourceContents * nX),
    sourceY = d.source.y + (sourceContents * nY),
    targetX = d.target.x - (targetContents * nX),
    targetY = d.target.y - (targetContents * nY);
    return 'M' + sourceX + ',' + sourceY + 'L' + targetX + ',' + targetY;  //построение стрелки
  });
  circle.attr('transform', function(d) { //трансформация ДЕ(стрелки)
    return 'translate(' + d.x + ',' + d.y + ')'; //перемещение
  });
}

// функция обновления графа  (вызывается когда нужна)
function update() {
  // связи (группа стрелок)
  path = path.data(links); //привязывает значения к элементам, которые будут созданы 
  
  // обновление существующих связей
  path.classed('selected', function(d) { return d === link_selected; })  //сравнение на идентичность
   .style('marker-start', function(d) { return d.isSource ? 'url(#start-arrow)' : ''; }) //Тернарный оператор-условия
    .style('marker-end', function(d) { return !d.isSource ? 'url(#end-arrow)' : ''; });


  // добавление новых связей
  path.enter().append('svg:path')
    .attr('class', 'link')  //присвоение классу связей
    .classed('selected', function(d) { return d === link_selected; })
    .style('marker-start', function(d) { return d.isSource ? 'url(#start-arrow)' : ''; })
    .style('marker-end', function(d) { return !d.isSource ? 'url(#end-arrow)' : ''; })
    .on('mousedown', function(d) {  // кнопка опущена
      if(d3.event.ctrlKey) return;  //если нажат ctrl
      // выбор связи
      link_mousedown = d; 
      if(link_mousedown === link_selected) link_selected = null; //если нажата клавиша на опред связи
      else link_selected = link_mousedown;
      node_selected = null;
      UpdateForm();  
      update();
    });

  // удаление старых связей
  path.exit().remove();


  // ДЕ (группа узлов) 
  // Функция function(d) решающая здесь: узлы известны по id, не по индексу!
  circle = circle.data(nodes, function(d) { return d.id; }); 

  // обновление существующих ДЕ 
  circle.selectAll('circle') 
  //если выделен ДЕ, то он подствечивается, если нет,то остается тем же цветом
  .style('fill', function(d) { return (d === node_selected) ? d3.rgb(colors(d.id)).brighter().toString() : colors(d.id); });

  // добавление новых ДЕ
  var g = circle.enter().append('svg:g');

  g.append('svg:circle')
    .attr('class', 'node')  //дает всем ДЕ единый стиль
    .attr('r', 13)  //радиус ДЕ
    .style('fill', function(d) { return (d === node_selected) ? d3.rgb(colors(d.id)).brighter().toString() : colors(d.id); })
    .style('stroke', function(d) { return d3.rgb(colors(d.id)).darker().toString(); })
    .on('mouseover', function(d) {  //mouseover - мышь появляется над элем
      if(!node_mousedown || d === node_mousedown) return;  //если не нажата на ДЕ или нетронута
      // при добавлении связи у ДЕ
      d3.select(this).attr('transform', 'scale(1.2)'); //при добав связи ДЕ, она увеличивается
    })
    .on('mouseout', function(d) { //mouseout - мышь уходит
      if(!node_mousedown || d === node_mousedown) return;
      // больше нет  трансформации
      d3.select(this).attr('transform', '');
    })

    .on('mousedown', function(d) { //кнопка нажата
      if(d3.event.ctrlKey) return; //если нажат ctrl

      // выделение ДЕ
      node_mousedown = d;
      if(node_mousedown === node_selected) node_selected = null;
      else node_selected = node_mousedown;
      link_selected = null;

      UpdateForm(); 

      // при создании связи-"прочерчиваем путь"
      drag_drop_line
        .style('marker-end', 'url(#end-arrow)')
        .classed('hidden', false) //стрелка показывается- назначение единого стиля
        .attr('d', 'M' + node_mousedown.x + ',' + node_mousedown.y + 'L' + node_mousedown.x + ',' + node_mousedown.y);

      update();
    })

    .on('mouseup', function(d) {  //кнопка отпущена
      if(!node_mousedown) return;

      drag_drop_line
        .classed('hidden', true)
        .style('marker-end', '');

      // проверка на сопротивление
      node_mouseup = d; 
      if(node_mouseup === node_mousedown) { resetMouseVars(); return; }  //мышь не активна

      // нет увеличения связей ДЕ
      d3.select(this).attr('transform', '');

      // направление связи
      var source, target;
        source = node_mousedown;
        source.isSource = true;
        target = node_mouseup;
        target.isSource = false;


      var link; //связи
      link = links.filter(function(l) {  //l-провод линии от текущей точки до указанной
        return (l.source === source && l.target === target);
      })[0];

      if(link) {
      } else {
        link = {source: source, target: target, Val: ""}; 
        links.push(link);
      }

      // выбор новой связи
      link_selected = link;
      node_selected = null;
      update();
    });



  // показание номеров ДЕ (id)
  g.append('svg:text') 
      .attr('x', 0)  //расположение номера на сфере
      .attr('y', 5)
      .attr('class', 'id')
      .text(function(d) { return d.id; });

  // удаление старых ДЕ
  circle.exit().remove();

  //приведение графика в движение. запустить или перезапустить моделирование, когда узлы изменены.
  force.start();
}

function mousedown() {   //кнопка опущена
  //предотвратите I-bar на сопротивление
  //d3.event.preventDefault(); не даст сработать событию по-умолчанию
  svg.classed('active', true);

  if(d3.event.ctrlKey || node_mousedown || link_mousedown) return;

  // вставка нового узла
  var de = d3.mouse(this),
      node = {id: ++nodeLastId, Name: ""};  //!!!!!!
  node.x = de[0];
  node.y = de[1];
  nodes.push(node);

  update();
}

function mousemove() {   //движение мыши- влияет на построение связи
  if(!node_mousedown) return;
  // обновление построения линий связи
  drag_drop_line.attr('d', 'M' + node_mousedown.x + ',' + node_mousedown.y + 'L' + d3.mouse(this)[0] + ',' + d3.mouse(this)[1]);

  update();
}

function mouseup() {  //отпускание кнопки
  if(node_mousedown) {
    // скрыть путь стрелки
    drag_drop_line
      .classed('hidden', true)
      .style('marker-end', '');
  }

  svg.classed('active', false);

  // очищение мыши от событий- она не активна
  resetMouseVars();
}

function ConnectLinksNode(node) {  //соединение ДЕ со связью (при соединении связи обновляются индексты у стрелок)
  var toConnect = links.filter(function(l) { //фильтрует все линии и выбирает только те, которые соед с ДЕ
    return (l.source === node || l.target === node);  //function(l) - выбираются линии
  });  //получается массив, его далее обрабатывают
  toConnect.map(function(l) {  //создается новый массив, кот обрабатет function(l)
    links.splice(links.indexOf(l), 1);  //удаление 1 элемента из массива: расположение элем определяет indexOf:позиция 1-го вхождения подстроки
  });
}

  // ответ 1 раз за нажатие 
  var KeyDown_Last = -1;


function keydown() {  //нажатие клавиши

  if(KeyDown_Last !== -1) return;
  KeyDown_Last = d3.event.keyCode;  //получение кода клавиши- что нажато

  // клавиша Ctrl
  if(d3.event.keyCode === 17) {
    circle.call(force.drag); // вызов функции перетаскивания объектов force.drag
    svg.classed('ctrl', true); 
  }

  if(!node_selected && !link_selected) return;  //клавиши: удаление ОБ
  switch(d3.event.keyCode) {
    case 46: // delete
      if(node_selected) {
        nodes.splice(nodes.indexOf(node_selected), 1);
        ConnectLinksNode(node_selected);
      } else if(link_selected) {
        links.splice(links.indexOf(link_selected), 1);
      }
      link_selected = null;
      node_selected = null;
      UpdateForm();  
      update();
      break;

case 76: // L - направление движения стрелки
    case 82: // R
      if(link_selected) {
        s = link_selected.source;
        t = link_selected.target;
        link_selected.source = t;
        link_selected.source.iSource = true;
        link_selected.target = s;
        link_selected.target.iSource = false;
      }
      update();
      break;
  }
}

function keyup() {  //клавиша отпущена
  KeyDown_Last = -1;

  // Ctrl (при нажатии её отключаются все остальные опции)
  if(d3.event.keyCode === 17) {
    circle
      .on('mousedown.drag', null)
      .on('touchstart.drag', null);
    svg.classed('ctrl', false);
  }
}


//функция заполнения формы и выделения объектов графа
var UpdateForm = function () {

   // выделение связи 
    if (link_selected) {
        debugger; //отладка
        if (link_selected) lblSelectedLink.innerHTML = "Связь " + "ДЕ"+ link_selected.source.id + "("+ link_selected.source.Name + ') к ' + "ДЕ"+ link_selected.target.id +"(" + link_selected.target.Name +")";
        else lblSelectedLink.innerHTML = "Связь " + "ДЕ"+ link_selected.target.id +"("+ link_selected.target.Name + ') к ' + "ДЕ"+ link_selected.source.id +"(" + link_selected.source.Name + ")";
        lblSelectedLinkVal.innerHTML = link_selected.Val == "" ? "" : "Вес связи: " + link_selected.Val;
        // Появление формы ввода для веса связи
        pnlLinkVal.style.display = link_selected.Val == "" ? "block" : "none";

        lblSelectedNode.innerHTML = "";  //При выделении связи надписи для ДЕ исчезают
        lblSelectedNodeName.innerHTML = "";  
        pnlNodeName.style.display = "none";
        return;
    } else {
        lblSelectedLink.innerHTML = "Не выбрана связь";
        lblSelectedLinkVal.innerHTML = "";
        pnlLinkVal.style.display = "none";
    }

    // Выделение ДЕ
    if (node_selected) {
        lblSelectedNode.innerHTML = "ДЕ " + node_selected.id;
        lblSelectedNodeName.innerHTML = node_selected.Name == "" ? "" : "Значение ДЕ: " + node_selected.Name;
        pnlNodeName.style.display = node_selected.Name == "" ? "block" : "none";

        lblSelectedLink.innerHTML = "";  
        lblSelectedLinkVal.innerHTML = "";  
        pnlLinkVal.style.display = "none";
    } else {
        lblSelectedNode.innerHTML = "Не выбрана ДЕ";
        lblSelectedNodeName.innerHTML = "";
        pnlNodeName.style.display = "none";
    }
}


//Назначение имени текущему узлу
var SetNodeName = function (NodeName) {
    if (node_selected == null) return;
    node_selected.Name = NodeName;  // передача данных (название ДЕ)
    cntNodeName.value = ""; // очищение формы после заполнения данных
    UpdateForm();

}

//Назначение веса текущей связи
var SetNodeLinkVal = function (NodeLinkVal) {
    if (link_selected == null) return;
    link_selected.Val = NodeLinkVal;  // Передача данных (вес связи)
    cntNodeLinkValue.value = "";  // очищение формы после заполнения данных
    ErrorLink.innerHTML = "";
    
    if (link_selected.Val > 1 )
    {
    ErrorLink.innerHTML = "Вес связи не должен быть больше 1";
    cntNodeLinkValue.value = "";
    return;    }
    if (link_selected.Val <= 0 )
    {
    ErrorLink.innerHTML = "Вес связи должен быть больше 0";
    cntNodeLinkValue.value = "";
    return;    }
    UpdateForm();
}

//Функция сохранения
var SaveNodes = function (cd) {
	var sendObj = {};
	sendObj.cd = cd;
	sendObj.nodes = [];
	sendObj.links = [];
	for (node of nodes) {
		sendObj.nodes.push(node.Name);
	}
	for (link of links) {
		sendObj.links.push({'source':link.source.Name, 'target':link.target.Name, 'Val':link.Val});		
	}

	$.ajax({
		url: 'process-nodes.php',
		type: 'post',
		data: {"saved" : JSON.stringify(sendObj)}, //перевод в сроку
		success: function(data) {
			alert( "Изменения успешно сохранены" );
		}
	});	
}

// приложение запускается здесь
svg.on('mousedown', mousedown)
  .on('mousemove', mousemove)
  .on('mouseup', mouseup);
d3.select(window)
  .on('keydown', keydown)
  .on('keyup', keyup);
update();


