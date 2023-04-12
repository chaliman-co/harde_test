const API_URL = "http://localhost:8000/api/v1";
export async function getFromApi(path) {
  try {
    let response = await fetch(resolvePath(path));
    return ApiResponse.create(response);
  } catch (err) {
    throw new NetworkError();
  }
}

export async function deleteFromApi(path) {
  try {
  let response = await fetch(resolvePath(path),{
    method: "DELETE"
  });
  return ApiResponse.create(response);
} catch (err) {
  throw new NetworkError();
}
}

export async function updateAtApi(path, payload) {
  try {
  let response = await fetch(resolvePath(path),{
    method: "PATCH",
    body: payload,
    headers: {
      "Content-Type": "application/json",
      // 'Content-Type': 'application/x-www-form-urlencoded',
    },
  });

  return ApiResponse.create(response);
} catch (err) {console.log(err)
  throw new NetworkError();
}
}

function resolvePath(path) {
  return API_URL + path;
}

export class NetworkError{}
class ApiResponse {
 
  static async create(fetchResponse) {
    const instance = new ApiResponse;
    instance.apiResponse = await fetchResponse.json();
    instance.fetchResponse = fetchResponse;
    return instance;
  }
  get succeeded() {
    return this.apiResponse.status === "success";
  }
  get data() {
    return this.apiResponse.data;
  }
  get failed() {
    return this.apiResponse.status === "failed";
  }
  get errorMessage() {
    return this.failed ? this.apiResponse.reason : null;
  }
  get errorDetails() {
    return this.failed ? this.apiResponse.errors : null;
  }
  get status() {
    return this.fetchResponse.status;
  }
}
export function showLoader() {
  document.getElementById("loader").style.display = "block";
}
export function hideLoader() {
  document.getElementById("loader").style.display = "none";
}