ativeRect.fromDirectional({
    required TextDirection textDirection,
    required double start,
    required double top,
    required double end,
    required double bottom,
  }) {
    final (double left, double right) = switch (textDirection) {
      TextDirection.rtl => (end, start),
      TextDirection.ltr => (start, end),
    };
    return RelativeRect.fromLTRB(left, top, right, bottom);
  }

  /// A rect that covers the entire container.
  static const RelativeRect fill = RelativeRect.fromLTRB(0.0, 0.0, 0.0, 0.0);

  /// Distance from the left side of the container to the left side of this rectangle.
  ///
  /// May be negative if the left side of the rectangle is outside of the container.
  final double left;

  /// Distance from the top side of the container to the top side of this rectangle.
  ///
  /// May be negative if the top side of the rectangle is outside of the container.
  final double top;

  /// Distance from the right side of the container to the right side of this rectangle.
  ///
  /// May be positive if the right side of the rectangle is outside of the container.
  final double right;

  /// Distance from the bottom side of the container to the bottom side of this rectangle.
  ///
  /// May be positive if the bottom side of the rectangle is outside of the container.
  final double bottom;

  /// Returns whether any of the values are greater than zero.
  ///
  /// This corresponds to one of the sides ([left], [top], [right], or [bottom]) having
  /// some positive inset towards the center.
  bool get hasInsets => left > 0.0 || top > 0.0 || right > 0.0 || bottom > 0.0;

  /// Returns a new rectangle object translated by the given offset.
  RelativeRect shift(Offset offset) {
    return RelativeRect.fromLTRB(
      left + offset.dx,
      top + offset.dy,
      right - offset.dx,
      bottom - offset.dy,
    );
  }

  /// Returns a new rectangle with edges moved outwards by the given delta.
  Re