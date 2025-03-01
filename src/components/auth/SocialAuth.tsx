import React from "react";
import { Button } from "../../components/ui/button";
import { Separator } from "../../components/ui/separator";
import { Facebook, Github, Mail } from "lucide-react";

interface SocialAuthProps {
  onSocialAuth?: (provider: string) => void;
  showSeparator?: boolean;
}

const SocialAuth = ({
  onSocialAuth = () => {},
  showSeparator = true,
}: SocialAuthProps) => {
  return (
    <div className="w-full space-y-4 bg-white p-4 rounded-md">
      {showSeparator && (
        <div className="relative flex items-center py-2">
          <Separator className="flex-grow" />
          <span className="mx-2 text-sm text-gray-500 font-medium">OR</span>
          <Separator className="flex-grow" />
        </div>
      )}

      <div className="flex flex-col space-y-2">
        <Button
          variant="outline"
          className="w-full border-gray-300 hover:bg-gray-50"
          onClick={() => onSocialAuth("google")}
        >
          <Mail className="mr-2 h-4 w-4" />
          Continue with Google
        </Button>

        <Button
          variant="outline"
          className="w-full border-gray-300 hover:bg-blue-50"
          onClick={() => onSocialAuth("facebook")}
        >
          <Facebook className="mr-2 h-4 w-4 text-blue-600" />
          Continue with Facebook
        </Button>

        <Button
          variant="outline"
          className="w-full border-gray-300 hover:bg-gray-50"
          onClick={() => onSocialAuth("github")}
        >
          <Github className="mr-2 h-4 w-4" />
          Continue with GitHub
        </Button>
      </div>
    </div>
  );
};

export default SocialAuth;
