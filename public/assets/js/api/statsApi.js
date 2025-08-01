const statsInstance = axios.create({
  baseURL: "/data/dummy/stats",
  timeout: 5000,
  //   headers: {
  //     "Content-Type": "application/json",
  //   },
});

statsInstance.interceptors.request.use(
  function (config) {
    console.log("stats : 요청이 전달되기 전 작업 수행");

    // 요청이 전달되기 전에 작업 수행
    return config;
  },
  function (error) {
    console.log("stats : 요청 오류가 있는 작업 수행");

    // 요청 오류가 있는 작업 수행
    return Promise.reject(error);
  }
);

statsInstance.interceptors.response.use(
  function (response) {
    console.log("stats : 정상응답 인터셉트");

    // 2xx 범위에 있는 상태 코드는 이 함수를 트리거 합니다.
    // 응답 데이터가 있는 작업 수행
    return response;
  },
  function (error) {
    console.log("stats : 에러 인터셉트");

    // 2xx 외의 범위에 있는 상태 코드는 이 함수를 트리거 합니다.
    // 응답 오류가 있는 작업 수행
    return Promise.reject(error);
  }
);

// 통계분석 API
export const statsAPI = {
  getDemographics: async () => {
    try {
      const response = await statsInstance.get("/demographics.json");

      if (response.data.result === "success") {
        console.log("api : 통계분석 demographics 데이터 조회 성공");

        return {
          success: true,
          data: response.data.data,
        };
      } else {
        console.log("api : 통계분석 demographics 데이터 조회 실패");

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

  getSales: async () => {
    try {
      const response = await statsInstance.get("/sales.json");

      if (response.data.result === "success") {
        console.log("api : 통계분석 sales 데이터 조회 성공");

        return {
          success: true,
          data: response.data.data,
        };
      } else {
        console.log("api : 통계분석 sales 데이터 조회 실패");

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

  getKeyword: async () => {
    try {
      const response = await statsInstance.get("/keyword.json");

      if (response.data.result === "success") {
        console.log("api : 통계분석 keyword 데이터 조회 성공");

        return {
          success: true,
          data: response.data.data,
        };
      } else {
        console.log("api : 통계분석 keyword 데이터 조회 실패");

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
window.customAPI = { stats: statsAPI };
