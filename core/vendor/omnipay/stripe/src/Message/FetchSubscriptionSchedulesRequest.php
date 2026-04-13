approaches the zero position.
  ///
  /// An anecdote for this most common case is 'forward is toward' the zero
  /// position.
  forward,

  /// Scrolling is happening in the positive scroll offset direction.
  ///
  /// For example, for the [GrowthDirection.forward] part of a vertical
  /// [AxisDirection.down] list, which is the default directional configuration
  /// of all scroll views, this means the content is moving up, exposing
  /// lower content.
  ///
  /// An anecdote for this most common case is reversing, or backing away, from
  /// the zero position.
  reverse,
}

/// Returns the opposite of the given [ScrollDirection].
///
/// Specifically, returns [ScrollDirection.reverse] for [ScrollDirection.forward]
/// (and vice versa) and returns [ScrollDirection.idle] for
/// [ScrollDirection.idle].
ScrollDirection flipScrollDirection(ScrollDirection direction) {
  return switch (direction) {
    ScrollDirection.idle => ScrollDirection.idle,
    ScrollDirection.forward => ScrollDirection.reverse,
    ScrollDirection.reverse => ScrollDirection.forward,
  };
}

/// Which part of the content inside the viewp