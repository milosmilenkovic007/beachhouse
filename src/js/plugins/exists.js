import $ from 'jquery';

export default function initExists() {
	$.fn.exists = function () {
		return this.length > 0;
	};
}
