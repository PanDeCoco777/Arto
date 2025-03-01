import React from "react";
import { Palette } from "lucide-react";

interface AuthHeaderProps {
  title?: string;
  subtitle?: string;
  logoSrc?: string;
}

const AuthHeader = ({
  title = "ArtiSell",
  subtitle = "Cebu Artisan Marketplace",
  logoSrc = "",
}: AuthHeaderProps) => {
  return (
    <header className="w-full bg-gradient-to-r from-amber-500 to-amber-600 p-4 shadow-md">
      <div className="container mx-auto flex items-center justify-center md:justify-start">
        <div className="flex items-center">
          {logoSrc ? (
            <img
              src={logoSrc}
              alt="ArtiSell Logo"
              className="h-12 w-auto mr-3"
            />
          ) : (
            <div className="bg-white p-2 rounded-full mr-3">
              <Palette className="h-8 w-8 text-amber-600" />
            </div>
          )}
          <div>
            <h1 className="text-2xl font-bold text-white">{title}</h1>
            <p className="text-sm text-amber-100">{subtitle}</p>
          </div>
        </div>
      </div>
    </header>
  );
};

export default AuthHeader;
