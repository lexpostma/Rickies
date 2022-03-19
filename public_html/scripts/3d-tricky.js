import * as THREE from 'three';
// import * as THREE from '/scripts/three.module.js';
// import * as THREE from '/scripts/three.js';
import { GLTFLoader } from '/scripts/GLTFLoader.js';

const canvReference = document.getElementById('3d_tricky');

const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);

const renderer = new THREE.WebGLRenderer({
	antialias: true,
	canvas: canvReference,
});
renderer.setSize(window.innerWidth, window.innerHeight);
// document.body.appendChild(renderer.domElement);

const loader = new GLTFLoader();

loader.load(
	'/3d-models/tricky.gltf',
	function (gltf) {
		// scene.add(gltf.scene);
		console.log('gltf success');
	},
	undefined,
	function (error) {
		console.error(error);
	}
);

const geometry = new THREE.BoxGeometry();
const material = new THREE.MeshBasicMaterial({ color: 0x0000ff });
const cube = new THREE.Mesh(geometry, material);
scene.add(cube);

camera.position.z = 5;

function animate() {
	requestAnimationFrame(animate);

	cube.rotation.x += 0.01;
	cube.rotation.y += 0.01;

	renderer.render(scene, camera);
}

animate();
