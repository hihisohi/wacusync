const dashboardInstance = axios.create({
  baseURL: "/data/dummy/dashboard",
  timeout: 5000,
  //   headers: {
  //     "Content-Type": "application/json",
  //   },
});

dashboardInstance.interceptors.request.use(
  function (config) {
    console.log("dashboard : 요청이 전달되기 전 작업 수행");

    // 요청이 전달되기 전에 작업 수행
    return config;
  },
  function (error) {
    console.log("dashboard : 요청 오류가 있는 작업 수행");

    // 요청 오류가 있는 작업 수행
    return Promise.reject(error);
  }
);

dashboardInstance.interceptors.response.use(
  function (response) {
    console.log("dashboard : 정상응답 인터셉트");

    // 2xx 범위에 있는 상태 코드는 이 함수를 트리거 합니다.
    // 응답 데이터가 있는 작업 수행
    return response;
  },
  function (error) {
    console.log("dashboard : 에러 인터셉트");

    // 2xx 외의 범위에 있는 상태 코드는 이 함수를 트리거 합니다.
    // 응답 오류가 있는 작업 수행
    return Promise.reject(error);
  }
);

// 대시보드 API
export const dashboardAPI = {
  getSummary: async () => {
    try {
      const response = await dashboardInstance.get("/summary.json");

      if (response.data.result === "success") {
        console.log("api : 대시보드 summary 데이터 조회 성공");

        return {
          success: true,
          data: response.data.data,
        };
      } else {
        console.log("api : 대시보드 summary 데이터 조회 실패");

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

  getInflow: async () => {
    try {
      const response = await dashboardInstance.get("/inflow.json");

      if (response.data.result === "success") {
        console.log("api : 대시보드 inflow 데이터 조회 성공");

        return {
          success: true,
          data: response.data.data,
        };
      } else {
        console.log("api : 대시보드 inflow 데이터 조회 실패");

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

  getRevisitingRate: async () => {
    try {
      const response = await dashboardInstance.get("/revisitingRate.json");

      if (response.data.result === "success") {
        console.log("api : 대시보드 revisitingRate 데이터 조회 성공");

        return {
          success: true,
          data: response.data.data,
        };
      } else {
        console.log("api : 대시보드 revisitingRate 데이터 조회 실패");

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

  getNoShowRate: async () => {
    try {
      const response = await dashboardInstance.get("/noShowRate.json");

      if (response.data.result === "success") {
        console.log("api : 대시보드 noShowRate 데이터 조회 성공");

        return {
          success: true,
          data: response.data.data,
        };
      } else {
        console.log("api : 대시보드 noShowRate 데이터 조회 실패");

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
window.customAPI = { dashboard: dashboardAPI };
