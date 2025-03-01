import React, { useState } from "react";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "../ui/tabs";
import LoginForm from "./LoginForm";
import SignupForm from "./SignupForm";
import SocialAuth from "./SocialAuth";

interface AuthFormProps {
  defaultTab?: "login" | "signup";
  onLogin?: (data: {
    email: string;
    password: string;
    rememberMe: boolean;
  }) => void;
  onSignup?: (data: {
    name: string;
    email: string;
    password: string;
    confirmPassword: string;
  }) => void;
  onSocialAuth?: (provider: string) => void;
  onForgotPassword?: () => void;
}

const AuthForm = ({
  defaultTab = "login",
  onLogin = () => {},
  onSignup = () => {},
  onSocialAuth = () => {},
  onForgotPassword = () => {},
}: AuthFormProps) => {
  const [activeTab, setActiveTab] = useState<"login" | "signup">(defaultTab);

  const handleTabChange = (value: string) => {
    setActiveTab(value as "login" | "signup");
  };

  return (
    <div className="w-full max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
      <div className="p-6">
        <Tabs
          defaultValue={defaultTab}
          value={activeTab}
          onValueChange={handleTabChange}
          className="w-full"
        >
          <TabsList className="grid w-full grid-cols-2 mb-6 bg-amber-50">
            <TabsTrigger
              value="login"
              className="data-[state=active]:bg-amber-600 data-[state=active]:text-white py-3"
            >
              Login
            </TabsTrigger>
            <TabsTrigger
              value="signup"
              className="data-[state=active]:bg-amber-600 data-[state=active]:text-white py-3"
            >
              Sign Up
            </TabsTrigger>
          </TabsList>

          <TabsContent value="login" className="space-y-4">
            <LoginForm onSubmit={onLogin} onForgotPassword={onForgotPassword} />
            <SocialAuth onSocialAuth={onSocialAuth} />
          </TabsContent>

          <TabsContent value="signup" className="space-y-4">
            <SignupForm onSubmit={onSignup} />
            <SocialAuth onSocialAuth={onSocialAuth} />
          </TabsContent>
        </Tabs>

        <div className="mt-6 text-center text-sm text-gray-600">
          {activeTab === "login" ? (
            <p>
              Don't have an account?{" "}
              <button
                onClick={() => setActiveTab("signup")}
                className="text-amber-600 hover:text-amber-800 font-medium"
              >
                Sign up
              </button>
            </p>
          ) : (
            <p>
              Already have an account?{" "}
              <button
                onClick={() => setActiveTab("login")}
                className="text-amber-600 hover:text-amber-800 font-medium"
              >
                Log in
              </button>
            </p>
          )}
        </div>
      </div>
    </div>
  );
};

export default AuthForm;
