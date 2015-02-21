<script type="text/javascript" src="v/webgl/glMatrix.js"></script>
<script type="text/javascript" src="v/webgl/webgl-utils.js"></script>

<script id="shader-fs" type="x-shader/x-fragment">

    precision mediump float;

	varying vec4 vColor;

    void main(void)
	{
        gl_FragColor = vColor;
    }

</script>

<script id="shader-vs" type="x-shader/x-vertex">

    attribute vec3 aVertexPosition;
    attribute vec4 aVertexColor;

    uniform mat4 uMVMatrix;
    uniform mat4 uPMatrix;

	varying vec4 vColor;

    void main(void)
	{
        gl_Position = uPMatrix * uMVMatrix * vec4(aVertexPosition, 1.0);
		vColor = aVertexColor;
    }

</script>

<script type="text/javascript">

    var gl;

    function initGL(canvas)
	{
        try
		{
            gl = canvas.getContext("experimental-webgl");
            gl.viewportWidth = canvas.width;
            gl.viewportHeight = canvas.height;
        }
		catch(e)
		{
        }
        if(!gl)
		{
            alert("Could not initialise WebGL, sorry :-(");
        }
    }

    function getShader(gl, id)
	{
        var shaderScript = document.getElementById(id);
        if (!shaderScript) { return null; }
        var str = "";
        var k = shaderScript.firstChild;
        while(k)
		{
            if (k.nodeType == 3) { str += k.textContent; }
            k = k.nextSibling;
        }
        var shader;
        if(shaderScript.type == "x-shader/x-fragment")
		{
            shader = gl.createShader(gl.FRAGMENT_SHADER);
        }
		else if(shaderScript.type == "x-shader/x-vertex")
		{
            shader = gl.createShader(gl.VERTEX_SHADER);
        }
		else { return null; }
        gl.shaderSource(shader, str);
        gl.compileShader(shader);
        if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS))
		{
            alert(gl.getShaderInfoLog(shader));
            return null;
        }
        return shader;
    }

    var shaderProgram;

    function initShaders()
	{
        var fragmentShader = getShader(gl, "shader-fs");
        var vertexShader = getShader(gl, "shader-vs");

        shaderProgram = gl.createProgram();

        gl.attachShader(shaderProgram, vertexShader);
        gl.attachShader(shaderProgram, fragmentShader);
        gl.linkProgram(shaderProgram);

        if (!gl.getProgramParameter(shaderProgram, gl.LINK_STATUS))
		{
            alert("Could not initialise shaders");
        }

        gl.useProgram(shaderProgram);

        shaderProgram.vertexPositionAttribute = gl.getAttribLocation(shaderProgram, "aVertexPosition");
        gl.enableVertexAttribArray(shaderProgram.vertexPositionAttribute);

        shaderProgram.vertexColorAttribute = gl.getAttribLocation(shaderProgram, "aVertexColor");
        gl.enableVertexAttribArray(shaderProgram.vertexColorAttribute);

        shaderProgram.pMatrixUniform  = gl.getUniformLocation(shaderProgram, "uPMatrix");

        shaderProgram.mvMatrixUniform = gl.getUniformLocation(shaderProgram, "uMVMatrix");
    }

    var mvMatrix = mat4.create();
	var mvMatrixStack = [];

    var pMatrix  = mat4.create();

	function mvPushMatrix()
	{
		var copy = mat4.create();
		mat4.set(mvMatrix, copy);
		mvMatrixStack.push(copy);
	}

	function mvPopMatrix()
	{
		if(mvMatrixStack.length == 0)
		{
			throw "Invalid popMatrix!";
		}
		mvMatrix = mvMatrixStack.pop();
	}

    function setMatrixUniforms()
	{
        gl.uniformMatrix4fv(shaderProgram.pMatrixUniform, false, pMatrix);
        gl.uniformMatrix4fv(shaderProgram.mvMatrixUniform, false, mvMatrix);
    }

	function degToRad(degrees)
	{
		return degrees * Math.PI / 180;
	}

    var grootPos;
    var grootCol;
    var grootIndex;

    function initBuffers()
	{
        grootPos = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, grootPos);
        vertices = [
			//Front face
            -1.0, -1.0,  1.0,
             1.0, -1.0,  1.0,
             1.0,  1.0,  1.0,
            -1.0,  1.0,  1.0,
			//Back face
            -1.0, -1.0, -1.0,
            -1.0,  1.0, -1.0,
             1.0,  1.0, -1.0,
             1.0, -1.0, -1.0,
			//Top face
            -1.0,  1.0, -1.0,
            -1.0,  1.0,  1.0,
             1.0,  1.0,  1.0,
             1.0,  1.0, -1.0,
			//Bottom face
            -1.0, -1.0, -1.0,
             1.0, -1.0, -1.0,
             1.0, -1.0,  1.0,
            -1.0, -1.0,  1.0,
			//Right face
             1.0, -1.0, -1.0,
             1.0,  1.0, -1.0,
             1.0,  1.0,  1.0,
             1.0, -1.0,  1.0,
			//Left face
            -1.0, -1.0, -1.0,
            -1.0, -1.0,  1.0,
            -1.0,  1.0,  1.0,
            -1.0,  1.0, -1.0,
        ];

        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertices), gl.STATIC_DRAW);
        grootPos.itemSize = 3;
        grootPos.numItems = 24;

        grootCol = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, grootCol);

		var c1 = [0.0, 0.7, 0.9, 1.0];
		var c2 = [0.0, 0.7, 0.9, 1.0];
		var c3 = [0.0, 0.0, 0.9, 1.0];
		var c4 = [0.0, 0.0, 0.9, 1.0];
		var c5 = [0.0, 0.3, 0.9, 1.0];
		var c6 = [0.0, 0.3, 0.9, 1.0];

        colors = [];
		colors.push(c1);
		colors.push(c2);
		colors.push(c3);
		colors.push(c4);
		colors.push(c5);
		colors.push(c6);

		var unpackedColors = [];
		for (var i in colors)
		{
			var color = colors[i];
			for(var j=0; j < 4; j++)
			{
				unpackedColors = unpackedColors.concat(color);
			}
		}

        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(unpackedColors), gl.STATIC_DRAW);
        grootCol.itemSize = 4;
        grootCol.numItems = 24;

        grootIndex = gl.createBuffer();
        gl.bindBuffer(gl.ELEMENT_ARRAY_BUFFER, grootIndex);
        indexes = [
			 0,  1,  2,    0,  2,  3,  // Front
			 4,  5,  6,    4,  6,  7,  // Back
			 8,  9, 10,    8, 10, 11,  // Top
			12, 13, 14,   12, 14, 15,  // Bottom
			16, 17, 18,   16, 18, 19,  // Right
			20, 21, 22,   20, 22, 23,  // Left
        ];
        gl.bufferData(gl.ELEMENT_ARRAY_BUFFER, new Uint16Array(indexes), gl.STATIC_DRAW);
        grootIndex.itemSize = 1;
        grootIndex.numItems = 36;
    }

	var rCube = 0;
	var xCubeRot = 0;
	var yCubeRot = 0;
	var zCubeRot = 0;
	var zCubeZoom = 0;

    function drawScene()
	{
        gl.viewport(0, 0, gl.viewportWidth, gl.viewportHeight);
        gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);

        mat4.perspective(45, gl.viewportWidth / gl.viewportHeight, 0.1, 100.0, pMatrix);

        mat4.identity(mvMatrix);

		var zAdjustment = (-1 * zCubeZoom / 10) - 6;
        mat4.translate(mvMatrix, [0.0, 0.0, zAdjustment]);

		mvPushMatrix();

		mat4.rotate(mvMatrix, degToRad(xCubeRot), [1, 0, 0]);
		mat4.rotate(mvMatrix, degToRad(yCubeRot), [0, 1, 0]);
		mat4.rotate(mvMatrix, degToRad(zCubeRot), [0, 0, 1]);

        gl.bindBuffer(gl.ARRAY_BUFFER, grootPos);
        gl.vertexAttribPointer(shaderProgram.vertexPositionAttribute, grootPos.itemSize, gl.FLOAT, false, 0, 0);

        gl.bindBuffer(gl.ARRAY_BUFFER, grootCol);
        gl.vertexAttribPointer(shaderProgram.vertexColorAttribute, grootCol.itemSize, gl.FLOAT, false, 0, 0);

		gl.bindBuffer(gl.ELEMENT_ARRAY_BUFFER, grootIndex);

        setMatrixUniforms();

        gl.drawElements(gl.TRIANGLES, grootIndex.numItems, gl.UNSIGNED_SHORT, 0);

		mvPopMatrix();
    }

	var lastTime = 0;

	function animate()
	{
		var timeNow = new Date().getTime();
		if(lastTime != 0)
		{
			var elapsed = timeNow - lastTime;
			rCube += (75 * elapsed) / 1000;
		}
		lastTime = timeNow;
	}

	function tick()
	{
		requestAnimFrame(tick);
		drawScene();
		//animate();
	}

    function webGLStart()
	{
        var canvas = document.getElementById("mainViewer");
        initGL(canvas);
        initShaders();
        initBuffers();
        gl.clearColor(0.0, 0.0, 0.0, 1.0);
        gl.enable(gl.DEPTH_TEST);
		tick();
    }

	$(document).ready(function()
	{
		webGLStart();
		$('#slider1').slider({
			slide: function(event, ui){
				var val1 = ui.value;
				xCubeRot = Math.round(val1 * 360 * .01);
				$('#viewerControls > div:nth-child(2) > div:nth-child(1) > div:nth-child(2)').html(xCubeRot);
			}
		});
		$('#slider2').slider({
			slide: function(event, ui){
				var val1 = ui.value;
				yCubeRot = Math.round(val1 * 360 * .01);
				$('#viewerControls > div:nth-child(2) > div:nth-child(2) > div:nth-child(2)').html(yCubeRot);
			}
		});
		$('#slider3').slider({
			slide: function(event, ui){
				var val1 = ui.value;
				zCubeRot = Math.round(val1 * 360 * .01);
				$('#viewerControls > div:nth-child(2) > div:nth-child(3) > div:nth-child(2)').html(zCubeRot);
			}
		});
		$('#slider4').slider({
			slide: function(event, ui){
				var val1 = ui.value;
				zCubeZoom = val1;
				$('#viewerControls > div:nth-child(2) > div:nth-child(1) > div:nth-child(4)').html(zCubeZoom);
			}
		});
		$('#slider5').slider({});
		$('#slider6').slider({});
	});
</script>
<canvas id="mainViewer" width="500" height="400"></canvas>
<div id='viewerControls'>
	<div>
		<div>
			<div id='slider1' class='slider'></div>
			<div id='slider4' class='slider'></div>
		</div>
		<div>
			<div id='slider2' class='slider'></div>
			<div id='slider5' class='slider'></div>
		</div>
		<div>
			<div id='slider3' class='slider'></div>
			<div id='slider6' class='slider'></div>
		</div>
	</div>
	<div>
		<div>
			<div>X Rot</div>
			<div>0</div>
			<div>Zoom</div>
			<div>0</div>
		</div>
		<div>
			<div>Y Rot</div>
			<div>0</div>
		</div>
		<div>
			<div>Z Rot</div>
			<div>0</div>
		</div>
	</div>
</div>
<style>
	#mainViewer
	{
		border: 5px ridge yellow;
	}
	#viewerControls
	{
		border: 5px ridge blue;
		float: right;
		height: 300px;
		width:  500px;
		background: lightBlue;
	}
	#viewerControls > div:nth-child(1) 
	{
		margin-left: 40px;
		margin-top: 20px;
	}
	#viewerControls > div:nth-child(1) > div
	{
		height: 40px;
	}
	#viewerControls > div:nth-child(1) > div > div
	{
		width: 180px;
		float: left;
	}
	#viewerControls > div:nth-child(1) > div > div:nth-child(2)
	{
		margin-left: 40px;
	}
	#viewerControls > div:nth-child(2)
	{
		border: 1px solid black;
		padding: 10px;
		border-radius: 10px;
		box-shadow: 1px 1px 1px 1px;
		width: 400px;
		margin-left: auto;
		margin-right: auto;
	}
	#viewerControls > div:nth-child(2) > div
	{
		height: 35px;
	}
	#viewerControls > div:nth-child(2) > div:nth-child(1)
	{
		margin-top: 15px;
	}
	#viewerControls > div:nth-child(2) > div > div
	{
		float: left;
	}
	#viewerControls > div:nth-child(2) > div > div:nth-child(1)
	{
		width: 60px;
		margin-left: 20px;
	}
	#viewerControls > div:nth-child(2) > div > div:nth-child(2)
	{
		width: 40px;
		text-align: right;
	}
	#viewerControls > div:nth-child(2) > div > div:nth-child(3)
	{
		width: 60px;
		margin-left: 50px;
	}
	#viewerControls > div:nth-child(2) > div > div:nth-child(4)
	{
		width: 40px;
		text-align: right;
	}
</style>
