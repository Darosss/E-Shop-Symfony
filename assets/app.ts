import { registerReactControllerComponents } from "@symfony/ux-react";

import "./styles/app.scss";
registerReactControllerComponents(
  require.context("./react/controllers/", true, /\.(j|t)sx?$/)
);

import "./bootstrap.js";
