import $ from 'jquery';

import initSuperImg from './super-img';
import initDevice from './device';
import initModernizr from './modernizr';
import initCarousel from './carousel';
import initImgLoaded from './img-loaded';
import initExists from './exists';
import initVideo from './video';
import initRedirectPopup from './redirect-popup';

export default function initPlugins() {
	initSuperImg();
	initDevice();
	initModernizr();
	initCarousel();
	initImgLoaded();
	initExists();
	initVideo();
	initRedirectPopup();
}
