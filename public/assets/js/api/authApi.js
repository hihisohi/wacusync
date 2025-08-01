const authInstance = axios.create({
  baseURL: "/data/dummy/auth",
  timeout: 5000,
  //   headers: {
  //     "Content-Type": "application/json",
  //   },
});

authInstance.interceptors.request.use(
  function (config) {
    console.log("auth : 요청이 전달되기 전 작업 수행");

    // 요청이 전달되기 전에 작업 수행
    return config;
  },
  function (error) {
    console.log("auth : 요청 오류가 있는 작업 수행");

    // 요청 오류가 있는 작업 수행
    return Promise.reject(error);
  }
);

authInstance.interceptors.response.use(
  function (response) {
    console.log("auth : 정상응답 인터셉트");

    // 2xx 범위에 있는 상태 코드는 이 함수를 트리거 합니다.
    // 응답 데이터가 있는 작업 수행
    return response;
  },
  function (error) {
    console.log("auth : 에러 인터셉트");

    // 2xx 외의 범위에 있는 상태 코드는 이 함수를 트리거 합니다.
    // 응답 오류가 있는 작업 수행
    return Promise.reject(error);
  }
);

// 로그인 API
export const authAPI = {
  // 로그인 요청
  login: async (credentials) => {
    try {
      const response = await authInstance.post("/login.json", credentials);

      if (response.data.result === "success") {
        console.log("api : 로그인 성공");

        return {
          success: true,
          data: response.data.data,
        };
      } else {
        console.log("api : 로그인 실패");

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

  // 로그아웃 요청
  logout: async () => {
    try {
      const response = await authInstance.post("/logout.json");
      return {
        success: true,
        data: response.data,
      };
    } catch (error) {
      return {
        success: false,
        error: error.response?.data || {
          code: "NETWORK_ERROR",
          message: "네트워크 오류가 발생했습니다.",
        },
      };
    }
  },

  // 토큰 갱신
  //   refreshToken: async () => {
  //     try {
  //       const response = await authInstance.post("/refresh.json");
  //       return {
  //         success: true,
  //         data: response.data,
  //       };
  //     } catch (error) {
  //       return {
  //         success: false,
  //         error: error.response?.data || {
  //           code: "NETWORK_ERROR",
  //           message: "네트워크 오류가 발생했습니다.",
  //         },
  //       };
  //     }
  //   },
};

// 전역 변수로 export
window.customAPI = { auth: authAPI };
