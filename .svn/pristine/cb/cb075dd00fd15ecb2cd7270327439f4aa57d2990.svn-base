import axios from "axios";

export function getFile(file) {
	if(file){
		return axios.defaults.baseURL + `/public/uploads/${file.savepath}${file.savename}`;
	}
	return '';
}