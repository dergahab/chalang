import React, { Component, ErrorInfo, ReactNode } from "react";

interface Props {
  children?: ReactNode;
}

interface State {
  hasError: boolean;
  error: Error | null;
  errorInfo: ErrorInfo | null;
}

class ErrorBoundary extends Component<Props, State> {
  public state: State = {
    hasError: false,
    error: null,
    errorInfo: null
  };

  public static getDerivedStateFromError(error: Error): State {
    // Update state so the next render will show the fallback UI.
    return { hasError: true, error, errorInfo: null };
  }

  public componentDidCatch(error: Error, errorInfo: ErrorInfo) {
    console.error("Uncaught error:", error, errorInfo);
    this.setState({
      error: error,
      errorInfo: errorInfo
    });
  }

  public render() {
    if (this.state.hasError) {
      return (
        <div style={{ padding: "50px", background: "#fee2e2", color: "#991b1b", fontFamily: "monospace", minHeight: "100vh" }}>
          <h1 style={{ fontSize: "2rem", marginBottom: "20px" }}>React Error Caught</h1>
          <h2 style={{ fontSize: "1.2rem", color: "#b91c1c", marginBottom: "10px" }}>{this.state.error?.toString()}</h2>
          <pre style={{ background: "#fff", padding: "20px", overflow: "auto", whiteSpace: "pre-wrap", border: "1px solid #fca5a5" }}>
            {this.state.errorInfo?.componentStack}
          </pre>
        </div>
      );
    }

    return this.props.children;
  }
}

export default ErrorBoundary;
