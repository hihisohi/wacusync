const authInstance = axios.create({
  baseURL: "/data/dummy/auth",
  timeout: 5000,
  //   headers: {
  //     "Content-Type": "application/json",
  //   },
});

authInstance.interceptors.request.use(
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

authInstance.interceptors.response.use(
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
export const authAPI = {
  // 로그인 요청
  login: async (credentials) => {
    try {
      const response = await authInstance.post("/login33.json", credentials);

      if (response.data.result === "success") {
        return {
          success: true,
          data: response.data,
        };
      } else {
        return {
          success: false,
          error: response.data,
        };
      }
    } catch (error) {
      console.log(error);
      return {
        success: false,
        error: error.response?.data,
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

// 사용 예시
const authExample = {
  // 로그인 예시
  handleLogin: async (username, password) => {
    const credentials = {
      username: username,
      password: password,
    };

    const result = await loginAPI.login(credentials);

    if (result.success) {
      // 로그인 성공
      console.log("로그인 성공:", result.data);

      if (result.data.token) {
        // 토큰 저장
        localStorage.setItem("authToken", result.data.token);
        localStorage.setItem("refreshToken", result.data.refreshToken);
        localStorage.setItem("user", JSON.stringify(result.data.user));
      }

      // 대시보드로 리다이렉트
      window.location.href = "/src/view/dashboard/";
    } else {
      // 로그인 실패
      console.error("로그인 실패:", result.error);

      switch (result.error.code) {
        case "NOT_FOUND_USER":
          alert("존재하지 않는 사용자입니다.");
          break;
        case "INVALID_PASSWORD":
          alert("비밀번호가 올바르지 않습니다.");
          break;
        case "ACCOUNT_LOCKED":
          alert("계정이 잠겨있습니다. 관리자에게 문의하세요.");
          break;
        default:
          alert("로그인 중 오류가 발생했습니다.");
      }
    }
  },

  // 로그아웃 예시
  handleLogout: async () => {
    const result = await loginAPI.logout();

    if (result.success) {
      // 로그아웃 성공
      localStorage.removeItem("authToken");
      localStorage.removeItem("refreshToken");
      localStorage.removeItem("user");

      // 로그인 페이지로 리다이렉트
      window.location.href = "/src/view/auth/login.php";
    } else {
      console.error("로그아웃 실패:", result.error);
    }
  },
};

// 전역 변수로 export
window.authAPI = authAPI;
window.authExample = authExample;
