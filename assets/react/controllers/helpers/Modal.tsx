import React, { useState } from "react";

interface ModalProps {
  isOpen: boolean;
  setIsOpen: React.Dispatch<React.SetStateAction<boolean>>;
  onClose: () => void;
  children: React.ReactNode;
  onSubmit?: () => void;
  submitTitle?: string;
  title?: string;
  closeOnSubmit?: boolean;
}

export default function (props: ModalProps) {
  //TODO: add optionally 'close' modal on mouse click
  // apart from modal content
  // no needed for now
  const {
    isOpen,
    setIsOpen,
    onClose,
    title = "",
    submitTitle,
    onSubmit,
    children,
    closeOnSubmit,
  } = props;

  if (!isOpen) return <></>;
  return (
    <>
      <div className="modal-wrapper">
        <div className="modal-content">
          <div className="modal-title">
            <h1>{title}</h1>
          </div>
          <div className="modal-body">{children}</div>

          <div className="modal-footer">
            <button
              onClick={() => {
                onClose();
                setIsOpen(false);
              }}
            >
              Close
            </button>
            {submitTitle ? (
              <button
                onClick={() => {
                  onSubmit();
                  if (closeOnSubmit) setIsOpen(false);
                }}
              ></button>
            ) : null}
          </div>
        </div>
        <div className="modal-background"></div>
      </div>
    </>
  );
}
