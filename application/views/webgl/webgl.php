<script type="text/javascript" src="v/webgl/glMatrix.js"></script>
<script type="text/javascript" src="v/webgl/webgl-utils.js"></script>
<script id="shader-fs" type="x-shader/x-fragment">
    precision mediump float;
	varying vec4 vColor;
    void main(void) {
        gl_FragColor = vColor;
    }
</script>
<script id="shader-vs" type="x-shader/x-vertex">
    attribute vec3 aVertexPosition;
    attribute vec4 aVertexColor;
    uniform mat4 uMVMatrix;
    uniform mat4 uPMatrix;
	varying vec4 vColor;
    void main(void) {
        gl_Position = uPMatrix * uMVMatrix * vec4(aVertexPosition, 1.0);
		vColor = aVertexColor;
    }
</script>
<script type="text/javascript">
    var gl;
    function initGL(canvas) {
        try {
            gl = canvas.getContext("experimental-webgl");
            gl.viewportWidth = canvas.width;
            gl.viewportHeight = canvas.height;
        } catch (e) {
        }
        if (!gl) {
            alert("Could not initialise WebGL, sorry :-(");
        }
    }
    function getShader(gl, id) {
        var shaderScript = document.getElementById(id);
        if (!shaderScript) { return null; }
        var str = "";
        var k = shaderScript.firstChild;
        while (k) {
            if (k.nodeType == 3) { str += k.textContent; }
            k = k.nextSibling;
        }
        var shader;
        if (shaderScript.type == "x-shader/x-fragment") {
            shader = gl.createShader(gl.FRAGMENT_SHADER);
        } else if (shaderScript.type == "x-shader/x-vertex") {
            shader = gl.createShader(gl.VERTEX_SHADER);
        } else { return null; }
        gl.shaderSource(shader, str);
        gl.compileShader(shader);
        if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
            alert(gl.getShaderInfoLog(shader));
            return null;
        }
        return shader;
    }
    var shaderProgram;
    function initShaders() {
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
        shaderProgram.pMatrixUniform  = gl.getUniformLocation(shaderProgram, "uPMatrix");
        shaderProgram.mvMatrixUniform = gl.getUniformLocation(shaderProgram, "uMVMatrix");
    }
    var mvMatrix = mat4.create();
	var mvMatrixStack = [];
    var pMatrix  = mat4.create();
	function mvPushMatrix(){
		var copy = mat4.create();
		mat4.set(mvMatrix, copy);
		mvMatrixStack.push(copy);
	}
	function mvPopMatrix(){
		if(mvMatrixStack.length == 0){
			throw "Invalid popMatrix!";
		}
		mvMatrix = mvMatrixStack.pop();
	}
    function setMatrixUniforms() {
        gl.uniformMatrix4fv(shaderProgram.pMatrixUniform, false, pMatrix);
        gl.uniformMatrix4fv(shaderProgram.mvMatrixUniform, false, mvMatrix);
    }
	function degToRad(degrees)
	{
		return degrees * Math.PI / 180;
	}
    var grootPos;
    var grootCol;
    function initBuffers() {
        grootPos = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, grootPos);
        vertices = [
             1.0,  1.0,  0.0,
            -1.0,  1.0,  0.0,
             1.0, -1.0,  0.0,
            -1.0, -1.0,  0.0
        ];
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertices), gl.STATIC_DRAW);
        grootPos.itemSize = 3;
        grootPos.numItems = 4;

        grootCol = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, grootCol);
        colors = [
             0.0, 0.99, 1.0, 1.0,
             0.0, 0.80, 1.0, 1.0,
             0.0, 0.80, 1.0, 1.0,
             0.0, 0.99, 1.0, 1.0
		];
/*
        colors = [];
		for (var i=0; i<4; i++){
			colors = colors.concat([0.0,0.4,0.0,0.9]);
		}
*/
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(colors), gl.STATIC_DRAW);
        grootCol.itemSize = 4;
        grootCol.numItems = 4;
    }
	var rSquare = 0;
    function drawScene() {
        gl.viewport(0, 0, gl.viewportWidth, gl.viewportHeight);
        gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);
        mat4.perspective(45, gl.viewportWidth / gl.viewportHeight, 0.1, 100.0, pMatrix);
        mat4.identity(mvMatrix);
        mat4.translate(mvMatrix, [0.0, 0.0, -6.0]);
		mvPushMatrix();
		mat4.rotate(mvMatrix, degToRad(rSquare), [0, 1, 0]);
		mat4.rotate(mvMatrix, degToRad(rSquare), [1, 0, 0]);
		mat4.rotate(mvMatrix, degToRad(rSquare), [0, 0, 1]);
        gl.bindBuffer(gl.ARRAY_BUFFER, grootPos);
        gl.vertexAttribPointer(shaderProgram.vertexPositionAttribute, grootPos.itemSize, gl.FLOAT, false, 0, 0);
        gl.bindBuffer(gl.ARRAY_BUFFER, grootCol);
        gl.vertexAttribPointer(shaderProgram.vertexColorAttribute, grootCol.itemSize, gl.FLOAT, false, 0, 0);
        setMatrixUniforms();
        gl.drawArrays(gl.TRIANGLE_STRIP, 0, grootPos.numItems);
		mvPopMatrix();
    }
	var lastTime = 0;
	function animate()
	{
		var timeNow = new Date().getTime();
		if(lastTime != 0){
			var elapsed = timeNow - lastTime;
			rSquare += (75 * elapsed) / 1000;
		}
		lastTime = timeNow;
	}
	function tick()
	{
		requestAnimFrame(tick);
		drawScene();
		animate();
	}
    function webGLStart() {
        var canvas = document.getElementById("canvas");
        initGL(canvas);
        initShaders();
        initBuffers();
        gl.clearColor(0.0, 0.0, 0.0, 1.0);
        gl.enable(gl.DEPTH_TEST);
		tick();
    }
	$(document).ready(function(){
		webGLStart();
	});
</script>
 <canvas id="canvas" width="500" height="400"></canvas>
