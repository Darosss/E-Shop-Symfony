import React from "react";

export default function (props: {
  fullName:
    | string
    | number
    | boolean
    | React.ReactElement<any, string | React.JSXElementConstructor<any>>
    | Iterable<React.ReactNode>
    | React.ReactPortal;
}) {
  return <div>Hello {props.fullName}</div>;
}
