import React, { useState } from "react";
import AuthHeader from "./auth/AuthHeader";
import AuthForm from "./auth/AuthForm";
import AuthBackground from "./auth/AuthBackground";

interface HomeProps {
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
  defaultTab?: "login" | "signup";
}

const Home = ({
  onLogin = () => {},
  onSignup = () => {},
  onSocialAuth = () => {},
  onForgotPassword = () => {},
  defaultTab = "login",
}: HomeProps) => {
  const handleLogin = (data: {
    email: string;
    password: string;
    rememberMe: boolean;
  }) => {
    console.log("Login attempt:", data);
    onLogin(data);
  };

  const handleSignup = (data: {
    name: string;
    email: string;
    password: string;
    confirmPassword: string;
  }) => {
    console.log("Signup attempt:", data);
    onSignup(data);
  };

  const handleSocialAuth = (provider: string) => {
    console.log(`Social auth with ${provider}`);
    onSocialAuth(provider);
  };

  const handleForgotPassword = () => {
    console.log("Forgot password clicked");
    onForgotPassword();
  };

  return (
    <div className="min-h-screen bg-amber-50">
      <AuthBackground>
        <div className="w-full max-w-4xl mx-auto">
          <div className="flex flex-col items-center">
            <div className="w-full mb-8">
              <AuthHeader
                title="ArtiSell"
                subtitle="Cebu Artisan Marketplace"
              />
            </div>

            <div className="w-full max-w-md">
              <div className="text-center mb-8">
                <h1 className="text-3xl font-bold text-amber-800">
                  Welcome to ArtiSell
                </h1>
                <p className="text-amber-700 mt-2">
                  Discover and shop authentic Cebuano arts, crafts, and
                  traditional foods
                </p>
              </div>

              <AuthForm
                defaultTab={defaultTab}
                onLogin={handleLogin}
                onSignup={handleSignup}
                onSocialAuth={handleSocialAuth}
                onForgotPassword={handleForgotPassword}
              />

              <div className="mt-8 text-center text-sm text-amber-700">
                <p>By continuing, you agree to ArtiSell's</p>
                <div className="flex justify-center space-x-2 mt-1">
                  <a
                    href="#"
                    className="text-amber-600 hover:text-amber-800 underline"
                  >
                    Terms of Service
                  </a>
                  <span>&</span>
                  <a
                    href="#"
                    className="text-amber-600 hover:text-amber-800 underline"
                  >
                    Privacy Policy
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </AuthBackground>
    </div>
  );
};

export default Home;
