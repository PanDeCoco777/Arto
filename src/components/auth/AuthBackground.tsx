import React from "react";
import { cn } from "@/lib/utils";

interface AuthBackgroundProps {
  children?: React.ReactNode;
}

const AuthBackground = ({ children }: AuthBackgroundProps = {}) => {
  return (
    <div className="relative min-h-screen w-full overflow-hidden bg-amber-50">
      {/* Decorative elements representing Cebuano cultural patterns */}
      <div className="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-amber-200 opacity-30 blur-3xl" />
      <div className="absolute top-1/4 -left-24 h-96 w-96 rounded-full bg-orange-200 opacity-30 blur-3xl" />
      <div className="absolute bottom-0 right-1/4 h-96 w-96 rounded-full bg-red-200 opacity-20 blur-3xl" />

      {/* Subtle pattern overlay */}
      <div className="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1601662528567-526cd06f6582?q=80&w=2070')] bg-cover opacity-5" />

      {/* Diagonal decorative lines */}
      <div className="absolute inset-0">
        <div className="absolute left-1/4 top-0 h-full w-px bg-gradient-to-b from-transparent via-amber-700/20 to-transparent" />
        <div className="absolute left-2/4 top-0 h-full w-px bg-gradient-to-b from-transparent via-amber-700/20 to-transparent" />
        <div className="absolute left-3/4 top-0 h-full w-px bg-gradient-to-b from-transparent via-amber-700/20 to-transparent" />

        <div className="absolute top-1/4 left-0 h-px w-full bg-gradient-to-r from-transparent via-amber-700/20 to-transparent" />
        <div className="absolute top-2/4 left-0 h-px w-full bg-gradient-to-r from-transparent via-amber-700/20 to-transparent" />
        <div className="absolute top-3/4 left-0 h-px w-full bg-gradient-to-r from-transparent via-amber-700/20 to-transparent" />
      </div>

      {/* Traditional pattern elements */}
      <div className="absolute top-10 left-10 h-20 w-20 rounded-full border-2 border-amber-600/20 opacity-30" />
      <div className="absolute top-10 right-10 h-20 w-20 rounded-full border-2 border-amber-600/20 opacity-30" />
      <div className="absolute bottom-10 left-10 h-20 w-20 rounded-full border-2 border-amber-600/20 opacity-30" />
      <div className="absolute bottom-10 right-10 h-20 w-20 rounded-full border-2 border-amber-600/20 opacity-30" />

      {/* Diamond patterns inspired by Cebuano textiles */}
      <div className="absolute top-1/3 left-1/4 h-32 w-32 rotate-45 border-2 border-amber-600/10 opacity-40" />
      <div className="absolute bottom-1/3 right-1/4 h-32 w-32 rotate-45 border-2 border-amber-600/10 opacity-40" />

      {/* Content container */}
      <div className="relative z-10 flex min-h-screen items-center justify-center px-4">
        {children}
      </div>
    </div>
  );
};

export default AuthBackground;
