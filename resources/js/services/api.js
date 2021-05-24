import axios from 'axios';

export default {
  httpGet: (url='', options={}, using='fetch') => {

    if (using='fetch') {
      // Using Fetch API
      return fetch(url, options)
        .then(resp => typeof resp === 'object' ? resp.json() : null)
        .catch(err => console.error(err));

    } else {
      // Using Axios library
      return axios.get(url, options)
        .then(resp => typeof resp === 'object' ? resp.data : null)
        .catch(err => console.error(err));
    }

  },

  httpPost: (url='', data={}, options={}, using='fetch') => {
    if (using='fetch') {
      // Using Fetch API
      const fetchOptions = {
        ... options,
        method: 'POST',
        headers: {
          'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(this.formData)
      };

      return fetch(url, fetchOptions)
        .then(resp => typeof resp === 'object' ? resp.json() : null)
        .catch(err => console.error(err));

    } else {
      // Using Axios library
      const axiosOpts = {
        ... options,
        headers: {
          'Content-Type': 'application/json;charset=utf-8',
        },
      };
      const data = JSON.stringify(data);

      return axios.post(url, data, axiosOpts)
        .then(resp => typeof resp === 'object' ? resp.data : null)
        .catch(err => console.error(err));
    }
  }

}
