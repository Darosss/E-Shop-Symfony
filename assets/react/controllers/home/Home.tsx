import React from "react";

export default function (props: { name: string }) {
  const { name } = props;

  return (
    <>
      <div className="home-top">
        <ContentTop name={name} />
      </div>
      <div className="home-middle">
        <ContentMiddle />
      </div>
      <div className="home-bottom">
        <ContentBottom />
      </div>
    </>
  );
}

function ContentTop(props: { name: string }) {
  const { name } = props;
  return <>Welcome {name ? ` again, ${name} ` : null}</>;
}

function ContentMiddle() {
  return <>CONTENT MIDDLE</>;
}

function ContentBottom() {
  return <>CONTENT BOTTOM</>;
}
