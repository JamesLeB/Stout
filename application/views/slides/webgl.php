<div id='webgl'>
	<button>GO</button>
	<canvas id='canvas'></canvas>
	<div id='webglStatus'></div>
</div>
<style>
	#webgl
	{
		background : lightgray;
		border : 1px solid gray;
		border-radius : 20px;
		box-shadow : 3px 3px 3px black;
		height : 500px;
		position : relative;
	}
	#webgl canvas
	{
		border : 2px inset gray;
		position : absolute;
		left : 50px;
		top  : 50px;
		height : 400px;
		width  : 600px;
	}
	#webgl button
	{
		position : absolute;
		left : 50px;
		top  : 10px;
	}
	#webglStatus
	{
		padding : 10px;
		border : 1px solid black;
		position : absolute;
		left : 700px;
		top  :  50px;
		height : 380px;
		width : 300px;
	}
</style>
<script>

    var gl;

	$('#webgl button').click(function(){
		webGLStart();
	});

    function webGLStart()
	{
		var message = 'Starting webgl...<br/>';
        var canvas = document.getElementById("canvas");
		$(canvas).css('background','white');

        message += initGL(canvas);
        message += initShaders();
        //initBuffers();

        //gl.clearColor(0.0, 0.0, 0.0, 1.0);
        //gl.enable(gl.DEPTH_TEST);

        //tick();
		message += 'All good :)';
		$('#webglStatus').html(message);
    }

    function initGL(canvas)
	{
		var a = 'Initializing canvas...<br/>';
        try {
            gl = canvas.getContext("experimental-webgl");
            gl.viewportWidth = canvas.width;
            gl.viewportHeight = canvas.height;
			a += 'gl initialized<br/>';
        } catch (e) {
			a += 'EXCEPTION thrown<br/>';
        }
        if (!gl) {
			a += 'FAILED to initialize gl<br/>';
        }
		return a;
    }
    function initShaders()
	{
		var a = 'Initializing Shaders...<br/>';
/*
        var fragmentShader = getShader(gl, "shader-fs");
        var vertexShader = getShader(gl, "shader-vs");

        shaderProgram = gl.createProgram();
        gl.attachShader(shaderProgram, vertexShader);
        gl.attachShader(shaderProgram, fragmentShader);
        gl.linkProgram(shaderProgram);

        if (!gl.getProgramParameter(shaderProgram, gl.LINK_STATUS)) {
            alert("Could not initialise shaders");
        }

        gl.useProgram(shaderProgram);

        shaderProgram.vertexPositionAttribute = gl.getAttribLocation(shaderProgram, "aVertexPosition");
        gl.enableVertexAttribArray(shaderProgram.vertexPositionAttribute);

        shaderProgram.vertexColorAttribute = gl.getAttribLocation(shaderProgram, "aVertexColor");
        gl.enableVertexAttribArray(shaderProgram.vertexColorAttribute);

        shaderProgram.pMatrixUniform = gl.getUniformLocation(shaderProgram, "uPMatrix");
        shaderProgram.mvMatrixUniform = gl.getUniformLocation(shaderProgram, "uMVMatrix");
*/
		return a;
    }
</script>
