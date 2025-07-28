const userInstance = axios.create({
  baseURL: "/data/dummy/user",
  timeout: 5000,
  //   headers: {
  //     "Content-Type": "application/json",
  //   },
});

userInstance.interceptors.request.use(
  function (config) {
    console.log("요청이 전달되기 전 작업 수행");

    // 요청이 전달되기 전에 작업 수행
    return config;
  },
  function (error) {
    console.log("요청 오류가 있는 작업 수행");

    // 요청 오류가 있는 작업 수행
    return Promise.reject(error);
  }
);

userInstance.interceptors.response.use(
  function (response) {
    console.log("정상응답 인터셉트");

    // 2xx 범위에 있는 상태 코드는 이 함수를 트리거 합니다.
    // 응답 데이터가 있는 작업 수행
    return response;
  },
  function (error) {
    console.log("에러 인터셉트");

    // 2xx 외의 범위에 있는 상태 코드는 이 함수를 트리거 합니다.
    // 응답 오류가 있는 작업 수행
    return Promise.reject(error);
  }
);

// 로그인 API
export const userAPI = {
  // 로그인 요청
  getUserInfo: async (token) => {
    try {
      const response = await userInstance.post("/me.json");

      if (response.data.result === "success") {
        console.log("api : 유저정보 조회 성공");

        return {
          success: true,
          data: response.data.data,
        };
      } else {
        console.log("api : 유저정보 조회 실패");

        return {
          success: false,
          errorCode: response.data.code,
          details: response.data.details,
        };
      }
    } catch (error) {
      console.log("error catch : " + error);

      return {
        success: false,
        errorCode: error.code,
        message: error.message,
      };
    }
  },
};

// 전역 변수로 export
window.customAPI = { user: userAPI };
