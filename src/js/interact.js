var c = document.getElementById('interact');
var d = c.getContext('2d');
var width = c.width = 320;
var height = c.height = 220;
var colors = ['limegreen','#fe2b63'];
var frogs = [];
var color = [];
var lifespan = 0;
var maxlifespan = 1000;
var interval = [];
var save = [];
var task = [];
var numberofFrogs = $('.numberofFrogs').eq(0).prop('id');
var frogCircle = document.getElementsByClassName('frog');
var querySelect = document.querySelectorAll('#values tr td');

function circle(x, y, radius, fillCircle){//Circle Shaped Frog

  d.beginPath();
  d.arc(x, y, radius, 0, Math.PI * 2, false);
  if(fillCircle){
    d.fill();
  } else{
    d.stroke();
  }
};  

function Frog(){//Frog Prototype Initialized with random x,y coordinates
	this.x = Math.floor(Math.random() * 300);
	this.y = Math.floor(Math.random() * 250);
	this.lifespan = 0;
	this.repro = false;
}

for(var i = 0; i < numberofFrogs; i++){//Collecting hidden data
	task[i] = {
		'id' : querySelect[i].id,
		'name' : querySelect[i].getAttribute('name'),
		'gender' : querySelect[i].getAttribute('gender'),
		'birth' : querySelect[i].getAttribute('birth'),
		'death' : querySelect[i].getAttribute('death'),
	} 
}

for(var i = 0; i < numberofFrogs; i++){//Frog Object with gender initialization
	if(task[i].gender == 'M'){
	   color[i] = d.fillStyle = colors[0];
	}else if(task[i].gender == 'F'){
	   color[i] = d.fillStyle = colors[1];  //colors[Math.floor((Math.random() * colors.length))];
	}
	frogs[i] = new Frog();
	frogs[i].id = 'Frog '+i;
	frogs[i].gender = color[i];
}

Frog.prototype.collision = function(){//Collision initialize
	if(this.x > width){
	 this.x = width;
	}
	 if(this.x < 0){
	 this.x = 0;
	}
	if(this.y > height){
	 this.y = height;
	}
	if(this.y < 0){
	 this.y = 0;
	}
}

Frog.prototype.draw = function(){//Drawing Frog initialize
	d.lineWidth = 2;
	d.strokeStyle = 'black';
	circle(this.x,this.y, 5, true);
}

Frog.prototype.update = function(){//Updating Frog coordinates
	var offsetx = Math.floor((Math.random() * 6 - 3) + 0.5);
	var offsety = Math.floor((Math.random() * 6 - 3) + 0.5);
	this.x += offsetx;
	this.y += offsety;
}

Frog.prototype.mating = function(){//Calculating mating as occurs
   for(var i = 0; i < frogs.length; i++){
      for(var j in frogs){
         if(parseInt(j) !== frogs.length - 1 && frogs[i].id !== frogs[parseInt(j)+1].id){
            if((frogs[i].x < (frogs[parseInt(j)+1].x + 5) && frogs[i].x > (frogs[parseInt(j)+1].x - 5)) && (frogs[i].y < (frogs[parseInt(j)+1].y + 5) && (frogs[i].y > frogs[parseInt(j)+1].y - 5))){
               if(frogs[i].gender !== frogs[parseInt(j)+1].gender){
               		frogs[i].repro = true;
               		frogs[parseInt(j)+1].repro = true;
               		if(frogs[i].repro == true){
               			$('.mating').eq(i).html('Active');
               			$('.mating').eq(parseInt(j)+1).html('Active');
               			var num = parseInt(document.getElementsByClassName('amount')[i].innerHTML);
               			num = num + 1;
               			$('.amount').eq(i).html(num);
               			$('.amount').eq(parseInt(j)+1).html(num);
               		} 
                  continue;
               }
            }
         }
      }
   }
}

Frog.prototype.maxlifespan = function(){//Beta
	if(this.lifespan == maxlifespan){
	  // delete this;//clearInterval();
	}
}

var i = 0;
var interval = setInterval(function(){//UNIT TEST runtime
d.clearRect(0,0,width,height);
for(var i = 0; i < frogs.length; i++){
   d.fillStyle = '#337AB7';
   d.font = '10px verdana';
   d.fillText(task[i].id,frogs[i].x-11,frogs[i].y+11);
   d.fillText(task[i].id,frogs[i].x+5,frogs[i].y+11);
   d.fillText(task[i].id,frogs[i].x-11,frogs[i].y-4);
   d.fillText(task[i].id,frogs[i].x+5,frogs[i].y-4);
   d.fillStyle = color[i];
   frogs[i].draw();
   frogs[i].collision();
   frogs[i].update();
   frogs[i].mating();
   frogs[i].lifespan += 1; 
}
}, 50);